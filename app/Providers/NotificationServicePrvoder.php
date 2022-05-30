<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use App\Models\Message;

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
            $count_unread_messages = Message::where([['type','support'],['is_read',0]])->get()->count();

            $view->with('notifications', $data);
            $view->with('count_unread_messages',$count_unread_messages);
        });

    }
}
