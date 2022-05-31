<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
class NotificationServicePrvoder extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view)  {
            $data = auth()->user() ? auth()->user()->unreadNotifications()->get() : [];

            $view->with('notifications', $data);
        });

    }
}
