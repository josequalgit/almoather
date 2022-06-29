<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slide;
use App\Http\Requests\SlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use Alert,Auth;

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

    public function edit($id)
    {
        $data = Slide::findOrFail($id);
        return view('dashboard.slides.edit',compact('data'));
    }

    public function store(SlideRequest $request)
    {
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

        activity()->log('Admin "'.Auth::user()->name.'"Created new slide');
        Alert::toast('Slide was created', 'success');


        return redirect()->route('dashboard.slides.index');

    }

    public function update(UpdateSlideRequest $request,$id)
    {

        $data = Slide::findOrFail($id);
        $data->update([
            'title'=>[
                'ar'=>$request->title_ar,
                'en'=>$request->title_en
            ],
            'description'=>[
                'ar'=>$request->description_ar,
                'en'=>$request->description_en
            ]
        ]);

        if($request->hasFile('image'))
        {
            $data->clearMediaCollection('slideImages');
            $data->addMedia($request->file('image'))
            ->toMediaCollection('slideImages');
        }

        activity()->log('Admin "'.Auth::user()->name.'"Updated a slide');
        Alert::toast('Slide was updated', 'success');

        return redirect()->route('dashboard.slides.index');


    }

    public function delete($id)
    {
        $slide = Slide::find($id);
        if($slide)
        {
            $slide->clearMediaCollection('slideImages');
            $slide->delete();

            return response()->json([
                'msg'=>'slide was deleted',
                'status'=>config('global.OK_STATUS')
            ],config('global.OK_STATUS'));
        }
        else
        {
            return response()->json([
                'msg'=>'ad not found',
                'status'=>config('global.NOT_FOUND_STATUS')
            ],config('global.NOT_FOUND_STATUS'));
        }
    }


}
