<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;

class FaqController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
       
        $data = FAQ::select(['question','answer'])->get()->map(function($item){
            return [
                'question'=>$item->question,
                'answer'=>$item->answer,
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'get_all_faqs'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
