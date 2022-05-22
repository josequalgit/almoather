<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PRedis;

class ChatController extends Controller
{
    
    public function index()
    {
        return view('dashboard.chat.index');
    }

    public function sendMessage(Request $request)
    {

        $redis = PRedis::connection();
        
        $data = ['message' => 'test'];
        $prefix = config('database.redis.options.prefix');
 
        $redis->publish('almuaather_database_.message', json_encode($data));
        
        return response()->json(['success' => true]);
    }
}
