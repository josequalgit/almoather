<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampaignGoal;
use Illuminate\Support\Facades\App;
use App\Http\Traits\ApiPaginator;

class CampaignGoalController extends Controller
{
    use ApiPaginator;
    private $trans_dir = 'messages.api.';

   public function index()
   {
    $itemsPaginated = CampaignGoal::get()->map(function($item){
        return [
            'id'=>$item->id,
            'name'=>$item->title
        ];
    });

    return response()->json([
        'msg'=>trans($this->trans_dir.'all_campaign_goals'),
        'data'=>$itemsPaginated,
        'status'=>config('global.OK_STATUS')
    ],config('global.OK_STATUS'));
   }

   public function rejectReasons()
   {
       return response()->json([
           'msg'=>'reasons',
           'data'=>[
               'reasons 1',
               'reasons 2',
               'reasons 3',
               'reasons 4',
               'reasons 5',
           ],
       ],config('global.OK_STATUS'));
   }
}
