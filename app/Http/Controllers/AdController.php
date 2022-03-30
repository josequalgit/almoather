<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\CustomerAdRating;
use App\Models\Category;
use App\Models\Influncer;
use App\Models\User;
use App\Models\InfluncerCategory;
use Auth,Alert;
use Carbon\Carbon;
use App\Models\InfluencerRateing;
use App\Models\MarketingAdRating;
use App\Models\AdsInfluencerMatch;


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

    public function edit($id)
    {
        $data = Ad::findOrFail($id);
        $matches = $data->matches()->where('chosen',1)->get();
        $unMatched = $data->matches()->where('chosen',0)->get();
        $categories = Category::get();
        return view('dashboard.ads.edit',compact('data','matches','unMatched','categories'));
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


        /** SAVE THE DATA */
        $ad->status = $request->status;
        $ad->category_id = $request->category_id;
        $ad->reject_note = $request->note ?? null;
        $ad->expense_type = $request->expense_type;
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

            if($request->expense_type == 'pve')  $infAds = $info->ads()->where('expense_type','pve')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
            else $infAds = $info->ads()->where('expense_type','pvn')->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();
           

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


  
}
