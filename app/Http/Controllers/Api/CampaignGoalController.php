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

   public function index()
   {
   

    $itemsPaginated = CampaignGoal::select(['id','title'])->get()->map(function($item){
        return [
            'id'=>$item->id,
            'name'=>$item->title
        ];
    });

    return response()->json([
        'msg'=>'all campaign goals',
        'data'=>$itemsPaginated,
        'status'=>config('global.OK_STATUS')
    ],config('global.OK_STATUS'));
   }
}
