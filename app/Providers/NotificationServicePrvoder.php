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
        $data = auth()->user() ? auth()->user()->unreadNotifications()->get() : [];
        //dd(auth()->user());
        view()->composer('*', function($view) use($data) {
            $view->with('notifications', $data);
        });

    }
}
