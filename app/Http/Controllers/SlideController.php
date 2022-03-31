<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slide;
use App\Http\Requests\SlideRequest;

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

    public function store(SlideRequest $request)
    {
       $addTitle =  array_merge($request->all(),['title'=>[
            'ar'=>$request->title_ar,
            'en'=>$request->title_en,
        ]]);

        $addDescription = array_merge($addTitle,['description'=>[
            'ar'=>$request->description_ar,
            'en'=>$request->description_en,
        ]]);




        $data = slide::create([
            'title'=>[
                'ar'=>$request->title_ar,
                'en'=>$request->title_en
            ],
            'description'=>[
                'ar'=>$request->description_ar,
                'en'=>$request->description_en
            ]
        ]);

        $data->addMedia($request->file('image'))
        ->toMediaCollection('slideImages');

        return redirect()->route('dashboard.slides.index');

    }

    
}
