<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AppSetting;
use App\Models\Ad;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    
    public function register()
    {
        view()->composer('*', function ($view)
        {
            $contact = AppSetting::where('key','contact_info')->first();
            $contact_info = $contact?json_decode($contact->value):[];

            $website_des_info = AppSetting::where('key','website_description')->first();
            $website_des = $website_des_info?json_decode($website_des_info->value):[];
           
            $pending_ads = Ad::where('status','pending')->get()->count();

            $view->with('contact_info', $contact_info ?? null);
            $view->with('website_des', $website_des ?? null);
            $view->with('pending_ads',$pending_ads);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $_SERVER['SERVER_NAME'] = gethostname();
        
           


    }
}
