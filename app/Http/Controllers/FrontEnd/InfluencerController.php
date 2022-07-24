<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    public function index()
    {
        return view('frontEnd.influencer.index');
    }
}
