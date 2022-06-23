<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AppSetting;

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
            $contact_info = $contact?json_decode($contact->value):null;

            $website_des_info = AppSetting::where('key','website_description')->first();
            $website_des = $website_des_info?json_decode($website_des_info->value):null;
            // dd($website_des);
            $view->with('contact_info', $contact_info ?? null);
            $view->with('website_des', $website_des ?? null);
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
