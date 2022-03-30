<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Models\Activity;
class LogController extends Controller
{
    public function index()
    {
        $data = Activity::orderBy('created_at','DESC')->paginate(10);

        return view('dashboard.log.index',compact('data'));
    }
}
