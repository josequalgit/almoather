<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Models\Relation;
class AdController extends Controller
{
    public function create()
    {
        $socialMedia = SocialMedia::get();
        $relations = Relation::get();
        return view('frontEnd.ads.create',compact('socialMedia','relations'));
    }
}
