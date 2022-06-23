<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ContactMessages;
use App\Models\AppSetting;
use App;
class ContactController extends Controller
{
    public function index()
    {
        $contact_us = Page::where('slug','contact_us')->first();
        $data = AppSetting::where('key','get_touch')->first();
        $get_in_touch = json_decode($data->value);
        $data = AppSetting::where('key','location')->first();
        $location = json_decode($data->value);

       
        return view('frontEnd.contactUs.index',compact('contact_us','get_in_touch','location'));
    }

    public function store_contact_messages(Request $request)
    {
        $data = ContactMessages::create($request->all());
        return response()->json([
            'msg'=>'data was added',
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
