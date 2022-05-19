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
        $data = Ad::where('status', $status)->orderBy('created_at', 'asc')->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        $counter = Ad::where('status', $status)->count();
        if (!$status) {
            $data = Ad::orderBy('created_at', 'desc')->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
            $counter = Ad::count();
        }
        return view('dashboard.ads.index', compact('data', 'counter'));
    }

    public function edit($id, $editable = null)
    {
        $data = Ad::findOrFail($id);
        $matches = $data->matches()->where('chosen', 1)->get();
        $unMatched = $data->matches()->where('chosen', 0)->get();
        // dd($unMatched);
        $categories = Category::get();
        $goals = CampaignGoal::select('title')->get();
        $countries = Country::get();
        return view('dashboard.ads.edit', compact('data', 'matches', 'unMatched', 'categories', 'editable', 'countries'));
    }

    public function update(Request $request, $id , $confirm = null)
    {

      // dd('s');

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
      //  dd($confirm);
        if($confirm||$request->note)
        {
            $ad->status = $request->status;
            $ad->category_id = $request->category_id;
            $ad->reject_note = $request->note ?? null;
            $ad->save();

            activity()->log('Admin "' . Auth::user()->name . '" Updated ad"' . $ad->store . '" to "' . $ad->status . '" status');
            
            $users = [Auth::user()];
            $info =[
                'msg'=>'Your Ad "'.$ad->store.'" has been accepted',
                'id'=>$data->id,
                'type'=>'Ad'
            ];
    
            Notification::send($users, new AddInfluencer($info));

            return response()->json([
                'msg' => 'status was changed',
                'status' => 200,
            ], 200);
        }
        else
        {
            $ad->category_id = $request->category_id;
            $ad->reject_note = $request->note ?? null;
            $ad->save();
        }

        if($request->change)
        {

            DB::table('ads_influencer_matches')->where('ad_id',$ad->id)->delete();
        }


        /** SAVE THE DATA */
       

        // STEP 1 - GET THE PROPERTY CATEGORIES
        $category = Category::find($request->category_id)->excludeCategories;

        $chosen_inf = [];
        $data = [];
        foreach ($category as $value) {
            $data = array_merge($chosen_inf, $value->influncers->pluck('id')->toArray());
        }

        /** NEW WAY */
      

        Alert::toast('Add was updated', 'success');


        $tokens = [$ad->customers->users->fcm_token];
        $data = [
            "title" => "Ads " . $ad->store . " Accepted",
            "body" => "Your Ad {$ad->store} has been accepted",
            "type" => 'Ad',
            'id' => $ad->id            
        ];

        $this->sendNotifications($tokens,$data);

        /** END WAY */
        if (!$ad->campaignGoals->profitable) {
            $allInfluencer = $this->calculateNonProfitableAds($request, $ad, $data);
        } else {
            $allInfluencer = $this->calculateProfitableAds($request, $ad, $data);
        }

        /** GET THE LOW ENGAGEMENT INFLUENCER*/

        return response()->json([
            'msg' => 'status was changed',
            'status' => 200,
        ], 200);
    }

    private function calculateProfitableAds($request, $ad, $data){
        $appPercentage = 0.15 * $ad->budget;
        $budgetAfterCutPercentage = $ad->budget - $appPercentage;
        $allInfluencer = Influncer::where('status', 'accepted')->whereNotIn('id', $data)->where('subscribers', '>', 0);
        if ($ad->ad_type == 'onsite') {
            $allInfluencer = $allInfluencer->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)
                    ->orWhere('city_id', $ad->city_id);
            });
        }
        //dd('here');
        $allInfluencer = $allInfluencer->get()->map(function($influencer){
            $influencerContractsRevenue = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->get()->map(function($query){
                return $query->ads->budget ? $query->revenue / $query->ads->budget : 0;
            });
            // dd($influencerContractsRevenue->sum());
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
            $budgetSum += $price;
            if ($budgetSum <= $budgetAfterCutPercentage) {
                array_push($chosenInfluencer, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>1,
                    'match'=>$influencer->revenue
                ]);
            } else {
                array_push($notChosenInfluencer, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>0,
                    'match'=>$influencer->revenue
                ]);
            }
        }

        return ['chosenInfluencer' => $chosenInfluencer,'notChosenInfluencer' => $notChosenInfluencer];
    }

    private function calculateNonProfitableAds($request, $ad, $data)
    {

        /**  BUDGET PERCENTAGE CALCULATION */
        $appPercentage = 0.15 * $ad->budget;
        $percentForBigInf = 100 - $request->engagement_rate;
        $budgetAfterCutPercentage = $ad->budget - $appPercentage;
        $budgetForSmallInfluencer = $request->engagement_rate / 100 * $budgetAfterCutPercentage;

        $budgeForBigInfluencer = $percentForBigInf / 100 * $budgetAfterCutPercentage;

        $chosenSubscribers = [];
        $notChosenInfluencer = [];
        $allSmallInfluencer = Influncer::where('status', 'accepted')->whereNotIn('id', $data)->where('subscribers', '<', 500000)->where('subscribers', '>', 0);
        if ($ad->ad_type == 'onsite') {
            $allSmallInfluencer = $allSmallInfluencer->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)
                    ->orWhere('city_id', $ad->city_id);
            });
        }
        $allSmallInfluencer = $allSmallInfluencer->get();

        foreach ($allSmallInfluencer as $key => $influencer) {
            $getLastMonthAds = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->sum('af');
            $getLastMonthAdsCount = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->count();

            $AOAF = $getLastMonthAdsCount ? $getLastMonthAds / $getLastMonthAdsCount : 0;

            $eng_rate = $AOAF / $influencer->subscribers;
            $allSmallInfluencer[$key]->eng_rate = $eng_rate;
        }

        $allSmallInfluencer = collect($allSmallInfluencer)->sortByDesc('eng_rate');

        $isOverBudge = 0;
        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        foreach ($allSmallInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;
            $isOverBudge += $price;
            if ($isOverBudge <= $budgetForSmallInfluencer) {
                array_push($chosenSubscribers, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>1,
                    'match'=>$influencer->eng_rate
                ]);
            } else {
                array_push($notChosenInfluencer, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>0,
                    'match'=>$influencer->eng_rate
                ]);
            }
        }

        /** GET BIG INFLUENCERS */
        $allBigInfluencer = Influncer::where('status', 'accepted')->whereNotIn('id', $data)->where('subscribers', '>=', 500000);

        if ($ad->ad_type == 'onsite') {
            $allBigInfluencer = $allBigInfluencer->where(function ($query) use ($ad) {
                $query->where('ads_out_country', 1)
                    ->orWhere('city_id', $ad->city_id);
            });
        }
        $allBigInfluencer = $allBigInfluencer->get();

        foreach ($allBigInfluencer as $key => $influencer) {
           
            $getLastMonthAds = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->sum('af');
            $getLastMonthAdsCount = $influencer->contracts()->orderBy('created_at', 'desc')->take(30)->count();

            $AOAF = $getLastMonthAdsCount ? $getLastMonthAds / $getLastMonthAdsCount : 0;

            $allBigInfluencer[$key]->AOAF = $AOAF;
        }

        $allBigInfluencer = collect($allBigInfluencer)->sortByDesc('AOAF');
        #CHECK IF THE BUDGET FOR LOW INFLUENCER IS OVER OR NOT
        $isOverBudge = 0;
        foreach ($allBigInfluencer as $key => $influencer) {
            $price = $ad->ad_type == 'online' ? $influencer->ad_price : $influencer->ad_onsite_price;

            $isOverBudge += $price;
            if ($isOverBudge <= $budgetForSmallInfluencer) {
                array_push($chosenSubscribers, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>1,
                    'match'=>$influencer->AOAF
                ]);
            } else {
                array_push($notChosenInfluencer, $influencer);
                AdsInfluencerMatch::create([
                    'ad_id'=>$ad->id,
                    'influencer_id'=>$influencer->id,
                    'chosen'=>0,
                    'match'=>$influencer->AOAF
                ]);
            }
        }

        
        /** MERGE THE TOW THE BIG AND THE SMALL INFLUENCER */
        return ['chosenInfluencer' => $chosenSubscribers,'notChosenInfluencer' => $notChosenInfluencer];
    }

    public function changeMatch($ad_id, $removed_inf, $chosen_inf)
    {
        $ad = Ad::find($ad_id);

        $chosenInf = $ad->onSite ? Influncer::find($chosen_inf)->ad_onsite_price : Influncer::find($chosen_inf)->ad_price;
        $oldInf = $ad->onSite ? Influncer::find($removed_inf)->ad_onsite_price : Influncer::find($removed_inf)->ad_price;
        $newBud = $ad->budget + $chosenInf - $oldInf;

        if ($chosenInf > $oldInf && $ad->budget > $newBud) {
            return response()->json([
                'msg' => 'please increase your budget',
                'status' => 401,
            ], 401);
        }

        $changeOld = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $removed_inf]])->first();
        $changeOld->chosen = 0;
        $changeOld->save();

        $changeNew = AdsInfluencerMatch::where([['ad_id', $ad->id], ['influencer_id', $chosen_inf]])->first();
        $changeNew->chosen = 1;
        $changeNew->save();

        return response()->json([
            'msg' => 'data was updated',
            'status' => 200,
        ], 200);
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
        $ad = Ad::find($ad_id);
        $contract = $ad->contacts;
        if (!$contract) {
            return response()->json([
                'msg' => 'contract was not found',
                'status' => config('global.NOT_FOUND_STATUS'),
            ], config('global.NOT_FOUND_STATUS'));
        }

        $data = new InfluencerContract;
        $data->content = $contract->content;
        $data->influencer_id = $request->influncers_id;
        $data->date = $request->date;
        $data->is_accepted = 0;
        $data->ad_id = $ad_id;
        $data->save();

        $influencer = Influncer::find($request->influncers_id);
        $name = $influencer->first_name . ' ' . $influencer->middle_name . ' ' . $influencer->last_name;

        $info = [
            'msg' => 'New Contract for ad "' . $ad->store . '"',
            'type' => 'Ad',
            'id' => $ad->id,
        ];

        Notification::send($influencer->users, new AddInfluencer($info));

        return response()->json([
            'msg' => 'contract was sent',
            'status' => config('global.OK_STATUS'),
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

        return response()->json([
            'msg' => 'video was added',
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

        return response()->json([
            'msg' => 'video was added',
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
