<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\UpdateBasicRequest;
use App\Http\Requests\UpdateContractAds;
use App\Http\Requests\UploadImageRequest;
use App\Http\Requests\UploadVideoRequest;
use App\Models\Ad;
use App\Models\AdsInfluencerMatch;
use App\Models\CampaignContract;
use App\Models\CampaignGoal;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Country;
use App\Models\InfluencerContract;
use App\Models\Influncer;
use App\Models\StoreLocation;
use App\Models\User;
use App\Notifications\AddInfluencer;
use App\Http\Traits\SendNotification;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    use SendNotification;
    public function index($status = null)
    {
        if ($status == 'All') {
            $data = Ad::orderBy('created_at', 'desc')->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
            $counter = Ad::count();
        }else{

            $statusCode = [
                'UnderReview'       => ['pending'],
                'Pending'           => ['approve','prepay','choosing_influencer'],
                'Active'            => ['fullpayment','active','progress'],
                'Finished'          => ['complete'],
                'Rejected'          => ['reject']
            ];

            $data = Ad::whereIn('status',$statusCode[$status])->orderBy('created_at', 'desc')->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
            $counter = Ad::whereIn('status',$statusCode[$status])->count();
        }

        return view('dashboard.ads.index', compact('data', 'counter'));
    }

    public function edit($id, $editable = null)
    {
        $data = Ad::findOrFail($id);
        $matchedInfluencers = $data->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $unMatched = $data->matches()->where('chosen', 0)->get();
        $serviceCategories = Category::where('type','service')->get();
        $productCategories = Category::where('type','product')->get();
        $goals = CampaignGoal::select('title')->get();
        $countries = Country::get();

        if($data->status != 'pending') return view('dashboard.ads.showAd',compact('data','matchedInfluencers','productCategories','serviceCategories','unMatched'));
        
        return view('dashboard.ads.edit', compact('data', 'matchedInfluencers', 'unMatched', 'serviceCategories','productCategories', 'editable', 'countries'));
    }

    public function update(Request $request, $id , $confirm = null)
    {

        /** VALIDATIONS */
        $ad = Ad::find($id);

        if (!$ad) {
            return response()->json([
                'msg' => 'ad not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        if (!$request->status) {
            return response()->json([
                'msg' => 'please add a status',
                'status' => config('global.UNAUTHORIZED_VALIDATION_STATUS'),
            ], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        if (!$request->category_id) {
            return response()->json([
                'msg' => 'please choose a category',
                'status' => config('global.UNAUTHORIZED_VALIDATION_STATUS'),
            ], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        if($confirm||$request->note)
        {
            $ad->status = $request->status;
            $ad->category_id = $request->category_id;
            $ad->eng_number = $request->engagement_rate;
            $ad->reject_note = $request->note ?? null;
            $ad->save();


            $tokens = [$ad->customers->users->fcm_token];
            if($request->note){
                $title = "Your campaign {$ad->store} has been rejected";
                $msg = "Your campaign {$ad->store} rejected because ({$request->note})";
            }else{
                $title = "Your campaign {$ad->store} has been accepted";
                $msg = "Congratulation! Your campaign {$ad->store} accepted Please go to campaign and complete the steps";
            }
           
            $data = [
                "title" => $title,
                "body" => $msg,
                "type" => 'Ad',
                'target_id' =>$ad->id
            ];


            activity()->log('Admin "' . Auth::user()->name . '" Updated ad"' . $ad->store . '" to "' . $ad->status . '" status');
            $this->sendNotifications($tokens,$data);

            $users = [$ad->customers->users];
            $info =[
                'msg' => $msg,
                'id' => $ad->id ,
                'type' => 'Ad'
            ];

            Notification::send($users, new AddInfluencer($info));
            Alert::toast('Ad was updated', 'success');

            return response()->json([
                'msg' => 'status was changed',
                'status' => 200,
            ], 200);
        }
        else
        {
            $ad->category_id = $request->category_id;
            $ad->reject_note = $request->note ?? null;
            $ad->eng_number = $request->engagement_rate;
            $ad->save();
        }

        if(!$confirm)
        {

            $ad->matches()->delete();
        }


        /** SAVE THE DATA */


        // STEP 1 - GET THE PROPERTY CATEGORIES
        $category = Category::find($request->category_id)->excludeCategories;

        $chosen_inf = [];
        $data = [];
        foreach ($category as $value) {
            $data = array_merge($chosen_inf, $value->influncers->pluck('id')->toArray());
        }

        if (!$ad->campaignGoals->profitable) {
            $noInfluencerReasons = $this->calculateNonProfitableAds($request, $ad, $data);
        } else {
            $noInfluencerReasons = $this->calculateProfitableAds($request, $ad, $data);
        }

        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();

        $appPercentage = 0.15 * $ad->budget;
        $budget = $ad->budget - $appPercentage;

        $influencersTable = view('dashboard.ads.include.influencer_table', compact('matchedInfluencers','ad','noInfluencerReasons','budget'))->render();
        return response()->json([
            'msg' => 'status was changed',
            'data' => $influencersTable,
            'totalInfluencers' => $matchedInfluencers->count(),
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

    private function calculateProfitableAds($request, $ad, $data){
        $noInfluencerReasons = [];
        $appPercentage = 0.15 * $ad->budget;
        $budgetAfterCutPercentage = $ad->budget - $appPercentage;

        $allInfluencer = Influncer::where('status', 'accepted')->whereNotIn('id', $data)->where('subscribers', '>', 0);
        if($allInfluencer->count() == 0){
            $noInfluencerReasons[] = "All influencers have been taken away from the campaign category";
            return $noInfluencerReasons;
        }

        if ($ad->ad_type == 'onsite') {
            $allInfluencer = $allInfluencer->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)->orWhere('city_id', $ad->city_id);
            });
        }
        
        $allInfluencer = $allInfluencer->get()->map(function($influencer){
            $influencerContractsRevenue = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->get()->map(function($query){
                return $query->ads->budget ? $query->revenue / $query->ads->budget : 0;
            });
           
            $influencerContractsRevenue = $influencerContractsRevenue->sum();
            $influencerContractsCount = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->count();

            $influencer->revenue = $influencerContractsCount ? $influencerContractsRevenue / $influencerContractsCount : 0;
            return $influencer;

        });

        $allInfluencer = collect($allInfluencer)->sortByDesc('revenue');
        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        $budgetSum = 0;
        $chosenInfluencer = [];
        $notChosenInfluencer = [];
        foreach ($allInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;
            
            if(($budgetSum + $price) <= $budgetAfterCutPercentage){
                $chosen = 1;
                $budgetSum += $price;
            }else{
                $chosen = 0;
            }

            AdsInfluencerMatch::updateOrCreate([
                'ad_id' => $ad->id,
                'influencer_id' => $influencer->id,
            ],[
                'chosen'=> $chosen,
                'match'=> $influencer->revenue,
            ]);
        }

        $allInfluencer = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->count();
        if($allInfluencer == 0){
            $noInfluencerReasons[] = "All influencers is over the campaign budget";
        }

        return $noInfluencerReasons;
    }

    public function changeStatus(Request $request,$contract_id)
    {
        $data = InfluencerContract::find($contract_id);
        if(!$data) return response()->json([
            'msg'=>'contract not found',
            'status'=>config('global.NOT_FOUND')
        ],config('global.NOT_FOUND'));

        /** IF THE AD IS REJECTED RETURN THE INFLUENCER STATUS TO NOT COMPLIED */
        if($request->rejectNote)
        {
            $data->status = 0;
            $data->link = null;
            $data->rejectNote = $request->rejectNote;
        }
        else
        {
            $data->link = $request->link;
            $data->rejectNote = null;

        }

        $data->admin_status = $request->status;
        $data->save();

        

        return response()->json([
            'msg'=>'status was changed',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    private function calculateNonProfitableAds($request, $ad, $data)
    {

        $noInfluencerReasons = [];

        /**  BUDGET PERCENTAGE CALCULATION */
        $appPercentage = 0.15 * $ad->budget;
        $percentForBigInf = 100 - $request->engagement_rate;
        $budgetAfterCutPercentage = $ad->budget - $appPercentage;
        $budgetForSmallInfluencer = $request->engagement_rate / 100 * $budgetAfterCutPercentage;

        $budgeForBigInfluencer = $percentForBigInf / 100 * $budgetAfterCutPercentage;

        $chosenSubscribers = [];
        $notChosenInfluencer = [];

        $influencers = Influncer::where('status', 'accepted')->whereNotIn('id', $data);
        if($influencers->count() == 0){
            $noInfluencerReasons[] = "All influencers have been taken away from the campaign category";
        }
        
        if ($ad->ad_type == 'onsite') {
            $influencers = $influencers->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)
                    ->orWhere('city_id', $ad->city_id);
            });
        }

        $engagementInfluencers = $influencers->get()->map(function($item){
            $getLastMonthAds = $item->contracts()->orderBy('created_at', 'desc')->take(30)->sum('af');
            $getLastMonthAdsCount = $item->contracts()->orderBy('created_at', 'desc')->take(30)->count();
           
            $item->AOAF = $getLastMonthAdsCount ? $getLastMonthAds / $getLastMonthAdsCount : 0;
            $item->eng_rate = $item->AOAF / $item->subscribers;

            return $item;
        });
        $engagementInfluencers = collect($engagementInfluencers)->sortByDesc('eng_rate');

        $isOverBudge = 0;
        $totalForSmallInfluencers = 0;
        $chosenInfluencers = [];

        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        foreach ($engagementInfluencers as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;
            
            if(($isOverBudge + $price) <= $budgetForSmallInfluencer){
                $isOverBudge += $price;
                $totalForSmallInfluencers += $price;
                $chosenInfluencers[] = $influencer->id;
                AdsInfluencerMatch::updateOrCreate([
                    'ad_id' => $ad->id,
                    'influencer_id' => $influencer->id,
                ],[
                    'chosen'=> 1,
                    'match'=> $influencer->eng_rate,
                    'AOAF' => $influencer->AOAF,
                ]);
            }
            
            if($totalForSmallInfluencers > $budgetForSmallInfluencer){
                break;
            }
           
        }
       
        $budgeForBigInfluencer = $budgeForBigInfluencer + ($budgetForSmallInfluencer - $totalForSmallInfluencers);

        $allBigInfluencer = $influencers->whereNotIn('id',$chosenInfluencers)->get()->map(function($item){
            $getLastMonthAds = $item->contracts()->orderBy('created_at', 'desc')->take(30)->sum('af');
            $getLastMonthAdsCount = $item->contracts()->orderBy('created_at', 'desc')->take(30)->count();
            $item->AOAF = $getLastMonthAdsCount ? $getLastMonthAds / $getLastMonthAdsCount : 0;

            return $item;
        });

        $allBigInfluencer = collect($allBigInfluencer)->sortByDesc('AOAF');
        if($allBigInfluencer->count() == 0){
            $noInfluencerReasons[] = "There are no influencers found";
        }

        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        $isOverBudge = 0;
        foreach ($allBigInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;

            if(($isOverBudge + $price) <= $budgeForBigInfluencer){
                $chosen = 1;
                $isOverBudge += $price;
            }else{
                $chosen = 0;
            }

            AdsInfluencerMatch::updateOrCreate([
                'ad_id'=>$ad->id,
                'influencer_id'=>$influencer->id,
            ],[
                'chosen'=> $chosen,
                'match'=> $influencer->AOAF,
                'AOAF' => $influencer->AOAF,
            ]);
            
        }

        $allInfluencer = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->count();
        if($allInfluencer == 0){
            $noInfluencerReasons[] = "All influencers is over the campaign budget";
        }

        return $noInfluencerReasons;
        
    }

    public function changeMatch($ad_id, $removed_inf_id, $chosen_inf_id)
    {
        $ad = Ad::find($ad_id);

        $chosen_inf = Influncer::find($chosen_inf_id);
        $chosenInfPrice = $ad->onSite ? $chosen_inf->ad_onsite_price : $chosen_inf->ad_price;

        $removed_inf = Influncer::find($removed_inf_id);
        $oldInfPrice = $ad->onSite ? $removed_inf->ad_onsite_price : $removed_inf->ad_price;

        $matchedPriceTotal = 0;
        $sumColumn = $ad->ad_type ? 'ad_price' : 'ad_onsite_price';
        $ad->matches()->where('chosen', 1)->get()->map(function($item) use(&$matchedPriceTotal,$sumColumn){
            $matchedPriceTotal += $item->influencers->{$sumColumn};
        });

        $appPercentage = 0.15 * $ad->budget;
        $budget = $ad->budget - $appPercentage;

        $remainingBudget = $budget - $matchedPriceTotal;
        $chosenInfPrice -= $remainingBudget;

        if ($chosenInfPrice > $oldInfPrice) {
            return response()->json([
                'msg' => 'please increase your budget',
                'status' => 401,
            ], 401);
        }

        $changeOld = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $removed_inf_id]])->first();
        $changeOld->chosen = 0;
        $changeOld->save();

        $changeNew = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $chosen_inf_id]])->first();
        $changeNew->chosen = 1;
        $changeNew->save();

        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $noInfluencerReasons = [];

        $influencersTable = view('dashboard.ads.include.influencer_table', compact('matchedInfluencers','ad','noInfluencerReasons','budget'))->render();
        return response()->json([
            'msg' => 'data was updated',
            'data' => $influencersTable,
            'status' => true,
        ], 200);
    }

    public function deleteMatchInfluencers($campaign_id,$influencer_id){
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'msg' => 'Campaign not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $influencer = Influncer::find($influencer_id);
        if (!$influencer) {
            return response()->json([
                'msg' => 'Influencer not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $ad->matches()->where('influencer_id', $influencer_id)->update(['status' =>'deleted']);
        
        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $noInfluencerReasons = [];

        $appPercentage = 0.15 * $ad->budget;
        $budget = $ad->budget - $appPercentage;

        $influencersTable = view('dashboard.ads.include.influencer_table', compact('matchedInfluencers','ad','noInfluencerReasons','budget'))->render();
        return response()->json([
            'msg' => 'data was updated',
            'data' => $influencersTable,
            'totalInfluencers' =>  $matchedInfluencers->count(),
            'status' => true,
        ], 200);

    }

    function approveInfluencersList($campaign_id){
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'msg' => 'Campaign not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $matches = $ad->matches()->where('chosen', 1)->where('status','!=','deleted')->get();
        $hasInfluencerError = false;
        $message = '<p>These influencers has no scenario or date</p><ol>';
        foreach($matches as $match){
            if(!$match->contract || !$match->contract->date || !$match->contract->scenario){
                $hasInfluencerError = true;
                $message .= '<li>' . $match->influencers->full_name . '</li>';
            }
        }
        $message .= '</ol>';

        if($hasInfluencerError){
            return response()->json([
                'msg'=>$message,
                'status'=> false
            ],config('global.OK_STATUS'));
        }

        $ad->update(['admin_approved_influencers' => 1]);

        return response()->json([
            'msg'=>'status was changed',
            'status'=> true
        ],config('global.OK_STATUS'));
    }

    public function getUnmatchedInfluencers($campaign_id,$influencer_id)
    {
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'msg' => 'Campaign not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $influencer = Influncer::find($influencer_id);
        if (!$influencer) {
            return response()->json([
                'msg' => 'Influencer not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $sumColumn = $ad->ad_type ? 'ad_price' : 'ad_onsite_price';

        $unMatched = $ad->matches()->where('chosen', 0)->where('status','!=','deleted')->get();
        $matchedPriceTotal = 0;
        $ad->matches()->where('chosen', 1)->get()->map(function($item) use(&$matchedPriceTotal,$sumColumn){
            $matchedPriceTotal += $item->influencers->{$sumColumn};
        });

        $appPercentage = 0.15 * $ad->budget;
        $budget = $ad->budget - $appPercentage;
        $remainingBudget = $budget - $matchedPriceTotal;

        $influencerPrice = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;
        $influencerPrice += $remainingBudget;

        $unmatchedInfluencersTable = view('dashboard.ads.include.unmatched_influencer', compact('unMatched','ad','influencer','influencerPrice','budget'))->render();

        return response()->json([
            'msg' => '',
            'influencers' => $unmatchedInfluencersTable,
            'count' => $unMatched->count(),
            'status' => true,
        ], config('global.OK_STATUS'));

    }

    public function seeMatched($ad_id)
    {
        $data = Ad::find($ad_id);
        if (!$data) {
            return response()->json([
                'msg' => 'ad not found',
                'status' => 404,
            ], 404);
        }

        $matches = $data->matches()->where('chosen', 1)->get()->map(function ($item) {
            return [
                'image' => $item->influencers->users->infulncerImage ? $item->influencers->users->infulncerImage['url'] : null,
                'name' => $item->influencers->first_name . ' ' . $item->influencers->middle_name . ' ' . $item->influencers->last_name,
                'match' => $item->match,
            ];
        });

        return response()->json([
            'msg' => 'ad was found',
            'data' => $matches,
            'status' => 200,
        ], 200);
    }

    private function makOneArray($arrayOfArray)
    {
        $data = [];
        foreach ($arrayOfArray as $key => $value) {
            $insideArray = $arrayOfArray[$key];
            dd($arrayOfArray);
            foreach ($insideArray as $value2) {
                dd($value2);

                array_push($data, $value2);
            }
        }

        return $data;
    }

    public function editContract($ad_id)
    {
        // dd('here');
        $data = Ad::findOrFail($ad_id)->contacts;
        // return $data;
        return view('dashboard.ads.editContract', compact('data'));
    }

    public function updateContract(UpdateContractAds $request, $ad_id)
    {
        $contract_id = Ad::findOrFail($ad_id)->contacts->id;
        $contract = CampaignContract::findOrFail($contract_id)->update($request->all());
        return redirect()->route('dashboard.ads.index');
    }

    public function sendContractToInfluencer(Request $request, $ad_id)
    {
        $data = $request->validate([
            "scenario"    => "required",
            "date"  => "required",
            "influncers_id"  => "required",
        ]);

        $ad = Ad::find($ad_id);
        if (!$ad) {
            return response()->json([
                'message' => 'AD not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $data = InfluencerContract::updateOrCreate([
            'ad_id' => $ad_id,
            'influencer_id' => $data['influncers_id']
        ],[
            'date' => $data['date'],
            'scenario' => $data['scenario'],
            'is_accepted' => 0,
            'af' => 0,
            'content' => '',
        ]);

        return response()->json([
            'message' => 'Data Saved Successfully',
            'status' => true,
        ], config('global.OK_STATUS'));
    }

    public function sendContractToCustomer(Request $request, $id)
    {
        $data = Contract::find($id);
        if (!$data) {
            return response()->json([
                'msg' => 'contract was not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $users = [User::find(1), User::find($data->customers->users->id)];
        $info = [
            'msg' => 'The contract for ad "' . $data->ads->store . '',
            'type' => 'Ad',
            'id' => $data->ads->id,
        ];
        Notification::send($users, new AddInfluencer($info));

        $data->content = $request->content;
        $data->date = $request->date;
        $data->save();

        return response()->json([
            'msg' => 'data was updated',
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));

    }

    public function seeContractInfluencer($contract_id)
    {
        $data = Contract::find($contract_id);
        if (!$data) {
            return response()->json([
                'msg' => 'contract was not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $influncers = $data->ads->matches()->where('chosen', 1)->get()->map(function ($item) {

            return [
                'image' => $item->influencers->users->infulncerImage ?? null,
                'name' => $item->influencers->full_name,
                'match' => $item->match,
            ];

        });

        return response()->json([
            'msg' => 'influncers',
            'influncers' => $influncers,
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));

    }

    public function uploadVideo(UploadVideoRequest $request, $id)
    {
        $data = Ad::find($id);
        if (!$data) {
            return response()->json([
                'msg' => 'ad was not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $data->addMedia($request->file('file'))
            ->toMediaCollection('adVideos');
        $numberOfVideos = count($data->videos);
        $last_video = $data->videos[$numberOfVideos - 1];
 

        return response()->json([
            'msg' => 'video was added',
            'data'=>[
                'added_video'=>$last_video,
                'number_of_videos'=>$numberOfVideos
            ],
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

    public function uploadImage(UploadImageRequest $request, $id)
    {
        $data = Ad::find($id);
        if (!$data) {
            return response()->json([
                'msg' => 'ad was not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $data->addMedia($request->file('file'))
            ->toMediaCollection('adImage');

            $numberOfImages = count($data->image);
            $last_image = $data->image[$numberOfImages - 1];
    

        return response()->json([
            'msg' => 'image was added',
            'data'=>[
                'added_image'=>$last_image,
                'number_of_images'=>$numberOfImages
            ],
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

    public function deleteFile($file_id)
    {
        $media = DB::table('media')->where('id', $file_id)->first();
        if (!$media) {
            return response()->json([
                'err' => 'file not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        Storage::deleteDirectory(public_path('storage/' . $media->model_id . '/' . $media->file_name));
        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);
        return response()->json([
            'msg' => 'file was deleted',
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

    public function update_basic(UpdateBasicRequest $request, $id)
    {
        $data = Ad::findOrFail($id);
        $data->store = $request->store;
        $data->cr_num = $request->cr_num;
        $data->is_vat = $request->is_vat;
        $data->relation = $request->relation;
        $data->marouf_num = $request->marouf_num;
        $data->budget = $request->budget;
        $data->about = $request->about;
        $data->about_product = $request->about_product;
        $data->store_link = $request->store_link;
        $data->save();

        if ($request->hasFile('logo')) {
            $data->ClearMediaCollection('logos');
            $data->addMedia($request->file('logo'))
                ->toMediaCollection('logos');
        }

        Alert::toast('Add was updated', 'success');

        return redirect()->route('dashboard.ads.edit', $id);
    }

    public function updateAddress(Request $request, $id)
    {
        $data = Ad::find($id);
        if (!$data) {
            return response()->json([
                'err' => 'ad not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $storeLocation = StoreLocation::find($data->storeLocations[0]->id);
        $storeLocation->city_id = $request->city_id;
        $storeLocation->area_id = $request->area_id;
        $storeLocation->country_id = $request->country_id;
        $storeLocation->save();

        return response()->json([
            'msg' => 'ad was updated',
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

}
