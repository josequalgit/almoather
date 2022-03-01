<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        return view('dashboard.index',compact('data'));
    }

    public function logout()
    {
        activity()->log('Admin "'.Auth::user()->name.'" logged out');
        Auth::logout();
        return back();
    }
}
