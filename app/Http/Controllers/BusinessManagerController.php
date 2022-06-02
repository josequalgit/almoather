<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Ad;

class BusinessManagerController extends Controller
{
    public function canceledContract()
    {
        $data = Contract::where('is_completed',0)->paginate(10);
        //return $data;

        return view('dashboard.contract.canceledContract',compact('data'));
    }

    public function rejectedAds()
    {
        $data = Ad::where('status','rejected')->paginate(10);

        return view('dashboard.ads.rejectedAds',compact('data'));

    }
}
