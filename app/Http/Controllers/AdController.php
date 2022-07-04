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
use App\Models\AppSetting;
use App\Models\Relation;
use App\Models\SocialMedia;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Traits\AdResponse;

class AdController extends Controller
{
    use SendNotification , AdResponse;
    public $notification_trans_dir = 'notifications.';

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
                'Rejected'          => ['rejected']
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
        $countries = Country::orderBy('sort')->get();

        if($data->status != 'pending' && $data->status != 'rejected') return view('dashboard.ads.showAd',compact('data','matchedInfluencers','productCategories','serviceCategories','unMatched'));
        
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

        if (!$request->category_id) {
            return response()->json([
                'msg' => 'please choose a category',
                'status' => config('global.UNAUTHORIZED_VALIDATION_STATUS'),
            ], config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        }

        
        if($confirm)
        {
            $ad->status = 'approve';
            $ad->category_id = $request->category_id;
            $ad->type = $request->type;
            $ad->eng_number = $request->engagement_rate;
            $ad->reject_note = null;
            $ad->save();


            $tokens = [$ad->customers->users->fcm_token];
            if($request->note){
                $title = 'rejected_campaign_title';
                $msg = 'rejected_campaign_msg';
            }else{
                $title = 'accepted_campaign_title';
                $msg = 'accepted_campaign_msg';
            }
            $data = [
                "title" => $title,
                "body" => $msg,
                "type" => 'Ad',
                'target_id' => $ad->id
            ];

            

            $this->sendNotifications($tokens,$data);

            activity()->log('Admin "' . Auth::user()->name . '" Updated ad"' . $ad->store . '" to "' . $ad->status . '" status');

            return response()->json([
                'msg' => 'status was changed',
                'status' => 200,
            ], 200);
        }
        else
        {
            $ad->category_id = $request->category_id;
            $ad->eng_number = $request->engagement_rate;
            $ad->type = $request->type;
            $ad->save();
            $ad->matches()->delete();
        }


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

        $this->calculateCampaignPrice($ad);
        $data = $ad;
        $influencersTable = view('dashboard.ads.include.influencer_table', compact('matchedInfluencers','data','noInfluencerReasons'))->render();
        
        return response()->json([
            'msg' => 'status was changed',
            'data' => $influencersTable,
            'totalInfluencers' => $matchedInfluencers->count(),
            'status' => config('global.OK_STATUS'),
        ], config('global.OK_STATUS'));
    }

    private function calculateProfitableAds($request, $ad, $data){
        $noInfluencerReasons = [];

        // $tax = AppSetting::where('key', 'tax')->first();
        // $tax = $tax ? $tax->value : config('global.TAX');
        // $tax = $tax/100 * $ad->budget;

        $relation = $ad->relations ? $ad->relations->app_profit : 10;
        $appPercentage = $relation / 100 * $ad->budget;

        // $appPercentage = $tax + $appPercentage;

        $budgetAfterCutPercentage = $ad->budget - $appPercentage;

        $allInfluencer = Influncer::where('status', 'accepted')->whereNotIn('id', $data);
        if($allInfluencer->count() == 0){
            $noInfluencerReasons[] = "All influencers have been taken away from the campaign category";
            return $noInfluencerReasons;
        }

        if ($ad->ad_type == 'onsite') {
            $allInfluencer = $allInfluencer->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)->orWhere('city_id', $ad->city_id);
            });
        }
        
        $allInfluencer = $allInfluencer->get()->sortByDesc(function($item){
            return $item->ROAS;
        });

        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        $budgetSum = 0;
        $chosenInfluencer = [];
        $notChosenInfluencer = [];
        foreach ($allInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_with_vat : $influencer->ad_onsite_price_with_vat;
            
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
                'match'=> $influencer->ROAS,
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
            $tokens = $data->influencers->users->fcm_token;
            $data = [
                "title" => trans($this->notification_trans_dir.'rejected_ad_inf',['ad_name'=>$data->ads->store]),
                "body" => $request->rejectNote,
                "type" => 'Ad',
                'target_id' =>$data->ads->id            
            ];
            $this->sendNotifications($tokens,$data);
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
        // $tax = AppSetting::where('key', 'tax')->first();
        // $tax = $tax ? $tax->value : config('global.TAX');

        // $tax = $tax/100 * $ad->budget;
        $relation = $ad->relations ? $ad->relations->app_profit : 10;
        $appPercentage = $relation / 100 * $ad->budget;

        // $appPercentage = $tax + $appPercentage;

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

        $engagementInfluencers = $influencers->get()->sortByDesc(function($item){
            return $item->engRate;
        });

        $isOverBudge = 0;
        $totalForSmallInfluencers = 0;
        $chosenInfluencers = [];

        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        foreach ($engagementInfluencers as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_with_vat : $influencer->ad_onsite_price_with_vat;
            
            if(($isOverBudge + $price) <= $budgetForSmallInfluencer){
                $isOverBudge += $price;
                $totalForSmallInfluencers += $price;
                $chosenInfluencers[] = $influencer->id;
                AdsInfluencerMatch::updateOrCreate([
                    'ad_id' => $ad->id,
                    'influencer_id' => $influencer->id,
                ],[
                    'chosen'=> 1,
                    'match'=> $influencer->engRate,
                    'AOAF' => $influencer->AOAF,
                ]);
            }
            
            if($totalForSmallInfluencers > $budgetForSmallInfluencer){
                break;
            }
           
        }
       
        $budgeForBigInfluencer = $budgeForBigInfluencer + ($budgetForSmallInfluencer - $totalForSmallInfluencers);

        $allBigInfluencer = $influencers->whereNotIn('id',$chosenInfluencers)->get()->sortByDesc(function($item){
            return $item->AOAF;
        });

        if($allBigInfluencer->count() == 0){
            $noInfluencerReasons[] = "There are no influencers found";
        }

        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        $isOverBudge = 0;
        foreach ($allBigInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_with_vat : $influencer->ad_onsite_price_with_vat;

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
        $chosenInfPrice = $ad->onSite ? $chosen_inf->ad_onsite_price_with_vat : $chosen_inf->ad_with_vat;

        $removed_inf = Influncer::find($removed_inf_id);
        $oldInfPrice = $ad->onSite ? $removed_inf->ad_onsite_price_with_vat : $removed_inf->ad_with_vat;

        $remainingBudget = $ad->budget - $ad->price_to_pay;
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

        $this->calculateCampaignPrice($ad);

        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $noInfluencerReasons = [];

        $data = $ad;

        $influencersTable = view('dashboard.ads.include.influencers', compact('matchedInfluencers','data','noInfluencerReasons'))->render();
        return response()->json([
            'msg' => 'data was updated',
            'data' => $influencersTable,
            'status' => true,
        ], 200);
    }

    public function addInfluencerMatch($ad_id, $chosen_inf_id)
    {
        $ad = Ad::find($ad_id);

        $chosen_inf = Influncer::find($chosen_inf_id);
        $chosenInfPrice = $ad->onSite ? $chosen_inf->ad_onsite_price_with_vat : $chosen_inf->ad_with_vat;

        $remainingBudget = $ad->budget - $ad->price_to_pay;
        $chosenInfPrice -= $remainingBudget;

        if ($chosenInfPrice > $ad->budget) {
            return response()->json([
                'msg' => 'please increase your budget',
                'status' => 401,
            ], 401);
        }

        $changeNew = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $chosen_inf_id]])->first();
        $changeNew->chosen = 1;
        $changeNew->save();

        $this->calculateCampaignPrice($ad);

        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $noInfluencerReasons = [];

        $data = $ad;
        $influencersTable = view('dashboard.ads.include.influencers', compact('matchedInfluencers','data','noInfluencerReasons'))->render();
        return response()->json([
            'msg' => 'data was updated',
            'data' => $influencersTable,
            'status' => true,
        ], 200);
    }

    //Delete influencers from matched list
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
        $ad->InfluencerContract()->where('influencer_id', $influencer_id)->delete();
        
        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $noInfluencerReasons = [];

        $this->calculateCampaignPrice($ad);
        
        $data = $ad;
        $influencersTable = view('dashboard.ads.include.influencers', compact('matchedInfluencers','data','noInfluencerReasons'))->render();
        return response()->json([
            'msg' => 'data was updated',
            'data' => $influencersTable,
            'totalInfluencers' =>  $matchedInfluencers->count(),
            'status' => true,
        ], 200);

    }

    //Admin approve influencers
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

        $this->calculateCampaignPrice($ad);

        $ad->update(['admin_approved_influencers' => 1]);
        $this->create_customer_contract($ad);

        return response()->json([
            'msg'=>'status was changed',
            'status'=> true
        ],config('global.OK_STATUS'));
    }

    private function calculateCampaignPrice($ad){
        $matchedInfluencers = $ad->matches()->where([['chosen', 1],['status','!=','deleted']])->get();
        $budgetSum = 0;
        foreach($matchedInfluencers as $match){
            $price = $ad->ad_type == 'online' ? $match->influencers->ad_with_vat : $match->influencers->ad_onsite_price_with_vat;
            $budgetSum += $price;
        }

        $relation = $ad->relations ? $ad->relations->app_profit : 10;
        $budgetSum += $relation / 100 * $budgetSum;

        $ad->update(['price_to_pay' => $budgetSum]);
    }

    //Get Unchosen Influencers list 
    public function getUnmatchedInfluencers($campaign_id,$influencer_id)
    {
        $type = $influencer_id > 0 ? 'replace' : 'add';
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'msg' => 'Campaign not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $unMatched = $ad->matches()->where('chosen', 0)->where('status','!=','deleted')->get(); 
        $remainingBudget = $ad->budget - $ad->price_to_pay;

        //When replace 
        if($influencer_id != 0){
            $influencer = Influncer::find($influencer_id);
            if (!$influencer) {
                return response()->json([
                    'msg' => 'Influencer not found',
                    'status' => false,
                ], config('global.NOT_FOUND_STATUS'));
            }
        
            $influencerPrice = $ad->ad_type == 'online' ? $influencer->ad_with_vat : $influencer->ad_onsite_price_with_vat;
            $influencerPrice += $remainingBudget;
        }else{
            //When add
            $influencerPrice = $remainingBudget;

        }

        $unmatchedInfluencersTable = view('dashboard.ads.include.unmatched_influencer', compact('unMatched','ad','influencerPrice','type'))->render();

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

    public function editContract($ad_id)
    {
        // dd('here');
        $data = Ad::findOrFail($ad_id)->contacts;
        // return $data;
        return view('dashboard.ads.editContract', compact('data'));
    }

    //Update Campaign contract
    public function updateContract(UpdateContractAds $request, $ad_id)
    {
        $data = $request->validate([
            "content"    => "required"
        ]);
        $contract = CampaignContract::where('ad_id',$ad_id)->first();

        if(!$contract){
            return response()->json([
                'message' => 'Contract not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }

        $contract->update(['content' => $request->content]);
        
        return response()->json([
            'message' => 'Data Saved Successfully',
            'status' => true,
        ], config('global.OK_STATUS'));
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

    public function update_info_view($id)
    {
        $data = Ad::findOrFail($id);
        $goals = CampaignGoal::get();
        $countries = Country::where('is_location',1)->orderBy('sort')->get();
        $socialMedias = SocialMedia::get();
        $realations  = Relation::get();
        return view('dashboard.ads.update',compact('data','goals','countries','socialMedias','realations'));
    }


    public function update_info_submit(Request $request, $id)
    {
        $data = Ad::findOrFail($id);
        if($request->hasFile('logo'))
        {
            $data->clearMediaCollection('logos');
            $data->addMedia($request->file('logo'))
            ->toMediaCollection('logos');
        }
        $data->update($request->all());
        Alert::toast('Ad was updated', 'success');
        return back();
    }

    private function create_customer_contract($ad)
    {
        $contractData = AppSetting::where('key', 'Customer Contract')->first();
        
        $content = json_decode($contractData->value);
        
        if ($contractData ) {
            return CampaignContract::updateOrCreate(['ad_id' => $ad->id],[
                'content' => json_decode($contractData->value),
                'is_accepted' => 0,
            ]);
        } else {
            return false;
        }

    }

    function show_contract($ad_id){
        $contract = CampaignContract::where('ad_id',$ad_id)->first();
        if(!$contract){
            return response()->json([
                'message' => 'Contract not found',
                'status' => false,
            ], 404);
        }

        $content = $contract->content;
        $content = str_replace("[[_CURRENT_DATE_]]", Carbon::now()->format('d/m/Y'), $content);

        return response()->json([
            'message' => '',
            'contract' => mb_convert_encoding( $content, 'UTF-8', 'UTF-8'),
            'status' => true,
        ], 200);
    }

    private function create_influencer_contract($ad_id = null, $customer)
    {
        $contractData = AppSetting::where('key', 'Influencer Contract')->first();
        
        $content = json_decode($contractData->value);
        $startDate = $ad->InfluencerContract()->orderBy('date','asc')->first();
        $endDate = $ad->InfluencerContract()->orderBy('date','desc')->first();

        $content = str_replace("[[_CONTRACT_NUM_]]", $ad->id, $content);
        $content = str_replace("[[_CURRENT_DATE_]]", Carbon::now()->format('d/m/Y'), $content);
        $content = str_replace("[[_CUSTOMER_NAME_]]", $ad->customers->full_name, $content);
        $content = str_replace("[[_STORE_NAME_]]", $ad->store, $content);
        $content = str_replace("[[_CUSTOMER_NATIONALITY_]]", $ad->customers->nationalities->getTranslation('name','ar'), $content);
        $content = str_replace("[[_CR_NUM_]]", $ad->cr_num, $content);
        $content = str_replace("[[_NATIONAL_NUM_]]", $ad->customers->id_number, $content);
        $content = str_replace("[[_PHONE_]]", $ad->customers->users->phone, $content);
        $content = str_replace("[[_EMAIL_]]", $ad->customers->users->email, $content);
        $content = str_replace("[[_PRICE_WITH_TAX_]]", number_format($ad->adBudgetWithVat), $content);
        $content = str_replace("[[_PRICE_]]", number_format($ad->budget), $content);
        $content = str_replace("[[_START_DATE_]]", $startDate->date->format('d/m/Y'), $content);
        $content = str_replace("[[_END_DATE_]]", $endDate->date->format('d/m/Y'), $content);
        $content = str_replace("[[_CAMPAIGN_GOAL_]]", $ad->campaignGoals->getTranslation('title','ar'), $content);
        
        if ($contractData) {
            return CampaignContract::updateOrCreate(['ad_id' => $ad->id],[
                'content' => $content,
                'is_accepted' => 0,
            ]);
        } else {
            return false;
        }

    }

    //Get campaign Contract In json format
    public function printContract($campaign_id){
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'message' => 'Campaign not found',
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
                'message'=>$message,
                'status'=> false
            ],401);
        }
        return response()->json([
            'message'=>'',
            'url' => route('dashboard.ads.contract-pdf',$ad->id),
            'status'=> true
        ],config('global.OK_STATUS'));

    }

    //Get campaign Contract
    public function getCampaignContract($campaign_id){
        $contract = CampaignContract::where('ad_id',$campaign_id)->first();
        $ad = Ad::find($campaign_id);
        if (!$ad) {
            return response()->json([
                'msg' => 'Campaign not found',
                'status' => false,
            ], config('global.NOT_FOUND_STATUS'));
        }
        
        if(!$contract){
            return response()->json([
                'message' => 'Contract not found',
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
                'message'=>$message,
                'status'=> false
            ],config('global.OK_STATUS'));
        }

        $content = $contract->content;
        if(!$contract->is_accepted){
            $startDate = $ad->InfluencerContract()->orderBy('date','asc')->first();
            $endDate = $ad->InfluencerContract()->orderBy('date','desc')->first();

            $content = str_replace("[[_CONTRACT_NUM_]]", $ad->id, $content);
            $content = str_replace("[[_CURRENT_DATE_]]", Carbon::now()->format('d/m/Y'), $content);
            $content = str_replace("[[_CUSTOMER_NAME_]]", $ad->customers->full_name, $content);
            $content = str_replace("[[_STORE_NAME_]]", $ad->store, $content);
            $content = str_replace("[[_CUSTOMER_NATIONALITY_]]", $ad->customers->nationalities->getTranslation('name','ar'), $content);
            $content = str_replace("[[_CR_NUM_]]", $ad->cr_num, $content);
            $content = str_replace("[[_NATIONAL_NUM_]]", $ad->customers->id_number, $content);
            $content = str_replace("[[_PHONE_]]", $ad->customers->users->phone, $content);
            $content = str_replace("[[_EMAIL_]]", $ad->customers->users->email, $content);
            $content = str_replace("[[_PRICE_WITH_TAX_]]", number_format($ad->adBudgetWithVat), $content);
            $content = str_replace("[[_PRICE_]]", number_format($ad->budget), $content);
            $content = str_replace("[[_START_DATE_]]", $startDate->date->format('d/m/Y'), $content);
            $content = str_replace("[[_END_DATE_]]", $endDate->date->format('d/m/Y'), $content);
            $content = str_replace("[[_CAMPAIGN_GOAL_]]", $ad->campaignGoals->getTranslation('title','ar'), $content);
        }

        $title = $contract->ads->store;

        return $this->generateContractPdf($content,$title);


    }

    function updateRejectNote(Request $request){
        $data = $request->validate([
            "reject_note"    => "required"
        ]);

        $ad = Ad::find($request->ad_id);

        $ad->update(['reject_note' => $data['reject_note'],'status' => 'rejected']);
        if($request->send_notification && $ad->customers->users->fcm_token){
            $tokens = [$ad->customers->users->fcm_token];
            $title = trans($this->notification_trans_dir.'rejected_campaign_title',['ad_name' => $ad->store]);
            $msg = trans($this->notification_trans_dir.'rejected_campaign_msg',['ad_name' => $ad->store,'reject_reason' => $request->reject_note]);

            $data = [
                "title" => $title,
                "body" => $msg,
                "type" => 'Ad',
                'target_id' =>$ad->id
            ];

            $this->sendNotifications($tokens,$data);
        }
        return response()->json([
            'message'=>'Note updated successfully',
            'status'=> true
        ],config('global.OK_STATUS'));
    }

}
