<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
{
    public function index()
    {
        $data = Slide::paginate(10);
        return view('dashboard.slides.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.slides.create');
    }
}
