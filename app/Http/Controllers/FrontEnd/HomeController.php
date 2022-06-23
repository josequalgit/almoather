<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Page;
use App\Models\FAQ;
use App;
class HomeController extends Controller
{
    public function index()
    {
        $setting = AppSetting::where('key','welcome_page')->first();
        $test_info = AppSetting::where('key','contact_info')->first();
        $about_us =  Page::where('slug','about_us')->first();
        $contact_us = Page::where('slug','contact_us')->first();
        $faq = Page::where('slug','faq')->first();
        $faqItems = FAQ::get();
        if($setting)
        {
            $get_value = json_decode($setting->value);
            $welcome_page_setting = (object)[
                'title'=>$get_value->title->{app()->getLocale()},
                'description'=>$get_value->description->{app()->getLocale()}
            ];

        }
        $data = [
            'welcome_message'=>$welcome_page_setting
        ];
        return view('frontEnd.index', compact(
            'data',
            'about_us',
            'faq',
            'faqItems',
            'contact_us',
        ));
    }


}
