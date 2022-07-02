<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSetting;
use App\Models\Page;
use App\Models\FAQ;
use App\Models\Team;
use App;
class HomeController extends Controller
{
    public function index()
    {
        $setting = AppSetting::where('key','welcome_page')->first()??null;
        $test_info = AppSetting::where('key','contact_info')->first()??null;
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
        else
        {
            $welcome_page_setting = (object)[];
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

    public function about_us()
    {
        $data = Page::where('slug','about_us')->firstOrFail();
        $team = Team::where('show',1)->get();
        
        return view('frontEnd.aboutus.index',compact('data','team'));
    }

    public function ourServices()
    {
        $data = Page::where('slug','our-services')->firstOrFail();

        return view('frontEnd.services.index',compact('data'));
    }


}
