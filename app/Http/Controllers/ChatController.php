<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    public function index()
    {
        return view('dashboard.chat.index');
    }

    public function sendMessage(Request $request)
    {
        
        Redis::publish('message.user-1', json_encode(["data" => 'test']));
    
    }
}
