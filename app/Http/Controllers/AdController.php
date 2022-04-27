<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\CustomerAdRating;
use App\Models\Category;
use App\Models\CampaignGoal;
use App\Models\Contract;
use App\Models\StoreLocation;
use App\Models\Country;
use App\Models\Influncer;
use App\Models\User;
use App\Models\InfluncerCategory;
use Auth,Alert,DB;
use Carbon\Carbon;
use App\Models\InfluencerRateing;
use App\Models\MarketingAdRating;
use App\Models\AdsInfluencerMatch;
use App\Http\Requests\UpdateContractAds;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInfluencer;
use App\Http\Requests\UploadVideoRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Requests\UpdateBasicRequest;
use Illuminate\Support\Facades\Storage;


class AdController extends Controller
{
    public function index($status = null)
    {
        $data = Ad::where('status',$status)->paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
        $counter = Ad::where('status',$status)->count();
        if(!$status)
        {
            $data = Ad::paginate(config('global.PAGINATION_NUMBER_DASHBOARD'));
            $counter = Ad::count();
        }
        return view('dashboard.ads.index',compact('data','counter'));
    }

    public function edit($id , $editable = null)
    {
        $data = Ad::findOrFail($id);
        $matches = $data->matches()->where('chosen',1)->get();
        $unMatched = $data->matches()->where('chosen',0)->get();
        $categories = Category::get();
        $goals = CampaignGoal::select('title')->get();
        $countries = Country::get();
        return view('dashboard.ads.edit',compact('data','matches','unMatched','categories','editable','countries'));
    }

    public function update(Request $request , $id)
    {
        /** VALIDATIONS */
        $ad = Ad::find($id);
        if(!$ad) return response()->json([
            'msg'=>'ad not found',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
        if(!$request->status) return response()->json([
            'msg'=>'please add a status',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        if(!$request->expense_type) return response()->json([
            'msg'=>'please add a type',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        if(!$request->category_id) return response()->json([
            'msg'=>'please choose a category',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        if(!$request->ad_type) return response()->json([
            'msg'=>'please choose a ad type',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));
        if(!$request->date) return response()->json([
            'msg'=>'please select an ad date',
            'status'=>config('global.UNAUTHORIZED_VALIDATION_STATUS')
        ],config('global.UNAUTHORIZED_VALIDATION_STATUS'));

       // return response()->json([$request->all()],500);

        /** SAVE THE DATA */
        $ad->status = $request->status;
        $ad->category_id = $request->category_id;
        $ad->reject_note = $request->note ?? null;
        $ad->expense_type = $request->expense_type;
        $ad->type = $request->ad_type;
        $ad->date = $request->date;
        $ad->save();

        // STEP 1 - GET THE PROPERTY CATEGORIES
        $category = Category::find($request->category_id)->excludeCategories;
        
        $chosen_inf = [];
        $data = [];
        foreach ($category as $value) {
           $data = array_merge($chosen_inf,$value->influncers->pluck('id')->toArray());
        }

        $influencers = Influncer::whereNotIn('id',$data)->get();

        /** NEW WAY */
        $startDate = Carbon::now()->subDays(28);
        $endDate = Carbon::now();
        $allAds28DaysSum = InfluencerRateing::whereBetween('created_at',[$startDate,$endDate])->sum('rate');
        $allInfMarketingRatting28DaysAgoSum = MarketingAdRating::whereBetween('created_at',[$startDate,$endDate])->sum('rate');
        $allCustomerMarketingRatting28DaysAgoSum = MarketingAdRating::whereBetween('created_at',[$startDate,$endDate])->sum('rate');
        $allRate = [];
        $allMatchedInf = [];
        foreach ($influencers as $info) {

            if($request->expense_type == 'pve')
            {
                $infAds = $info->ads()->where('expense_type','pve')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
            }
            else
            {
                
                $pvn = $info->ads()->where('expense_type','pvn')->whereBetween('created_at',[$startDate,$endDate])->sum('budget');
                $pve = $info->ads()->where('expense_type','pve')->whereBetween('created_at',[$startDate,$endDate])->sum('budget');
                if($pvn > $pve)
                {
                    $infAds = $info->ads()->where('expense_type','pvn')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
                }
                elseif($pvn < $pve)
                {
                    $infAds = $info->ads()->where('expense_type','pve')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
                }
                else
                {
                    $infAds = $info->ads()->where('expense_type','pvn')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
                }
            }
           

            /** INF RATTING */
            $infoRatting28DaysAgo =InfluencerRateing::whereIn('ad_id',$infAds)->whereBetween('created_at',[$startDate,$endDate])->get();
            $sumRatting28DaysAgoInf =InfluencerRateing::whereIn('ad_id',$infAds)->whereBetween('created_at',[$startDate,$endDate])->sum('rate');

            /** MARKETING RATTING */
            $infMarketingRatting28DaysAgo = MarketingAdRating::whereIn('ad_id',$infAds)->get();
            $sumInfMarketingRatting28DaysAgo = MarketingAdRating::whereIn('ad_id',$infAds)->sum('rate');

            /** CUSTOMER RATTING */
            $customerMarketingRatting28DaysAgo = CustomerAdRating::whereIn('ad_id',$infAds)->get();
            $sumCustomerMarketingRatting28DaysAgo = CustomerAdRating::whereIn('ad_id',$infAds)->sum('rate');

            /** GET ALL SUCCEED ADS */
            $countCustomerMarketingRatting28DaysAgo = CustomerAdRating::whereIn('ad_id',$infAds)->where('rate','>', 0)->count('rate');

            /** cal's */

            /** Influencer ratting */
            $infRatting = ($sumRatting28DaysAgoInf != 0 && $allAds28DaysSum != 0)?$sumRatting28DaysAgoInf*100/$allAds28DaysSum:0;
            /** Marketing ratting */
            $infMarketing = ($sumInfMarketingRatting28DaysAgo != 0)?$sumInfMarketingRatting28DaysAgo*100/$allInfMarketingRatting28DaysAgoSum:0;
            /** Customer ratting */
            $customerMarketing = ($sumCustomerMarketingRatting28DaysAgo != 0)?$sumCustomerMarketingRatting28DaysAgo*100/$allCustomerMarketingRatting28DaysAgoSum:0;
            /** Sum all ratting's*/
            $sumAllNumbers = $infRatting + $infMarketing + $customerMarketing + $countCustomerMarketingRatting28DaysAgo;

            /** Push the influencer with the match percentage  */
            $obj = [
                'match'=>$sumAllNumbers/4,
                'id'=>$info->id,
                'ad_id'=>$id,
                'price'=>($request->onSite == '1') ? $info->ad_onsite_price:$info->ad_price,
            ];
            
            array_push($allMatchedInf,$obj);
        }

         usort($allMatchedInf, fn($a, $b) => strcmp($b['match'],$a['match']));


         $adBudget = $request->adBudget;
             
         foreach ($allMatchedInf as $key => $value) {
            $count_budget = 0;
            if($count_budget <= $adBudget )
            {
           
                AdsInfluencerMatch::create([
                    'ad_id'=>$value['ad_id'],
                    'influencer_id'=>$value['id'],
                    'match'=>$value['match'],
                    'chosen'=>1
                ]);
                $count_budget = $count_budget + $value['price'];
            }
            else
            {
                AdsInfluencerMatch::create([
                    'ad_id'=>$value['ad_id'],
                    'influencer_id'=>$value['id'],
                    'match'=>$value['match'],
                    'chosen'=>0
                ]);
            }
         }

   
        /** NEW WAY */
        activity()->log('Admin "'.Auth::user()->name.'" Updated ad"'. $ad->store .'" to "'.$ad->status.'" status');
        Alert::toast('Add was updated', 'success');


        return response()->json([
            'msg'=>'data was updated',
            'status'=>201
        ],201);
    }

    public function changeMatch($ad_id,$removed_inf,$chosen_inf)
    {
        $ad = Ad::find($ad_id);

        $chosenInf = $ad->onSite ? User::find($chosen_inf)->influncers->ad_onsite_price:User::find($chosen_inf)->influncers->ad_price;
        $oldInf = $ad->onSite ? User::find($removed_inf)->influncers->ad_onsite_price:User::find($removed_inf)->influncers->ad_price;
        $newBud = $ad->budget + $chosenInf - $oldInf;


        if($chosenInf > $oldInf && $ad->budget > $newBud)
        {
            return response()->json([
                'msg'=>'please increase your budget',
                'status'=>401
            ],401);
        }



        $changeOld = AdsInfluencerMatch::where([['ad_id',$ad->id],['influencer_id',User::find($removed_inf)->influncers->id]])->first();
        $changeOld->chosen = 0;
        $changeOld->save();   
        


        $changeNew = AdsInfluencerMatch::where([['ad_id',$ad->id],['influencer_id',User::find($chosen_inf)->influncers->id]])->first();
        $changeNew->chosen = 1;
        $changeNew->save();

        
        return response()->json([
            'msg'=>'data was updated',
            'status'=>200
        ],200);
    }

    public function seeMatched($ad_id)
    {
        $data = Ad::find($ad_id);
        if(!$data) return response()->json([
            'msg'=>'ad not found',
            'status'=>404
        ],404);
        $matches = $data->matches()->where('chosen',1)->get()->map(function($item){
            return[
                'image'=>$item->influencers->users->infulncerImage,
                'name'=>$item->influencers->full_name,
                'match'=>$item->match
            ];
        });

        return response()->json([
            'msg'=>'ad was found',
            'data'=>$matches,
            'status'=>200
        ],200);
    }

    private function makOneArray($arrayOfArray)
    {
        $data = [];
        foreach ($arrayOfArray as $key => $value) {
            $insideArray = $arrayOfArray[$key];
            dd($arrayOfArray);
                foreach ($insideArray as $value2) {
                    dd($value2);

                    array_push($data,$value2);
                }
        }

        return $data;
    }

    public function editContract ($ad_id)
    {
        $data = Ad::findOrFail($ad_id)->contacts;
        return view('dashboard.ads.editContract',compact('data'));
    }

    public function updateContract(UpdateContractAds $request,$ad_id)
    {
        $contract_id = Ad::findOrFail($ad_id)->contacts->id;
        $contract = Contract::findOrFail($contract_id)->update($request->all());
        return redirect()->route('dashboard.ads.index');
    }

    public function sendContractToInfluencer(Request $request,$ad_id)
    {
        $contract = Ad::find($ad_id)->contacts;
        if(!$contract) return response()->json([
            'msg'=>'contract was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        
        $data = new Contract;
        $data->title = $contract->title;
        $data->content = $contract->content;
        $data->influencer_id =$request->influncers_id;
        $data->date = $request->date;
        $data->ad_id = $ad_id;
        $data->save();
        
        return response()->json([
            'msg'=>'contract was sent',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function sendContractToCustomer (Request $request , $id)
    {
        $data = Contract::find($id);
        if(!$data) return response()->json([
            'msg'=>'contract was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $users = [User::find(1),User::find($data->customers->users->id)];
        $info =[
            'msg'=>'The contract for ad "'.$data->ads->store.''
        ];
        Notification::send($users, new AddInfluencer($info));

        $data->content = $request->content;
        $data->date = $request->date;
        $data->save();

        return response()->json([
            'msg'=>'data was updated',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }

    public function seeContractInfluencer($contract_id)
    {
        $data = Contract::find($contract_id);
        if(!$data) return response()->json([
            'msg'=>'contract was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        $influncers = $data->ads->matches()->where('chosen',1)->get()->map(function($item){

            return [
                'image'=>$item->influencers->users->infulncerImage??null,
                'name'=>$item->influencers->full_name,
                'match'=>$item->match,
            ];

        });
        
        return response()->json([
            'msg'=>'influncers',
            'influncers'=>$influncers,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));

    }


    public function uploadVideo(UploadVideoRequest $request,$id)
    {
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'msg'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->addMedia($request->file('file'))
        ->toMediaCollection('adVideos');


        return response()->json([
            'msg'=>'video was added',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function uploadImage(UploadImageRequest $request,$id)
    {
        $data = Ad::find($id);
        if(!$data) return response()->json([
            'msg'=>'ad was not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $data->addMedia($request->file('file'))
        ->toMediaCollection('adImage');


        return response()->json([
            'msg'=>'video was added',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function deleteFile($file_id)
    {
        $media = DB::table('media')->where('id',$file_id)->first();
        if(!$media)return response()->json([
            'err'=>'file not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));
        Storage::deleteDirectory(public_path('storage/'.$media->model_id.'/'.$media->file_name));
        $model_type = $media->model_type;

        $model = $model_type::find($media->model_id);
        $model->deleteMedia($media->id);
        return response()->json([
            'msg'=>'file was deleted',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function update_basic(UpdateBasicRequest $request , $id)
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

        Alert::toast('Add was updated', 'success');

        return redirect()->route('dashboard.ads.edit',$id);
    }

    public function updateAddress(Request $request , $id)
    {
        $data = Ad::find($id);
        if(!$data)return response()->json([
            'err'=>'ad not found',
            'status'=>config('global.NOT_FOUND_STATUS')
        ],config('global.NOT_FOUND_STATUS'));

        $storeLocation = StoreLocation::find($data->storeLocations[0]->id);
        $storeLocation->city_id = $request->city_id;
        $storeLocation->area_id = $request->area_id;
        $storeLocation->country_id = $request->country_id;
        $storeLocation->save();

        return response()->json([
            'msg'=>'ad was updated',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }


  
}
