<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfluncerCategory;
use App\Http\Requests\InfluncerCategoryRequest;
use Auth , Alert;
class InfluncerCategoryController extends Controller
{
    public function index()
    {
        $data = InfluncerCategory::paginate(10);
        return view('dashboard.influncerCategories.index',compact('data'));
    }

    public function create()
    {
        return view('dashboard.influncerCategories.create');
    }

    public function edit($id)
    {
        $data = InfluncerCategory::findOrFail($id);
        return view('dashboard.influncerCategories.edit',compact('data'));
    }

    public function store(InfluncerCategoryRequest $request)
    {
        $addTranslate = [
            'name'=>[
                'ar'=>$request->name_ar,
                'en'=>$request->name_en,
            ],
            'type'=>$request->type,
        ];
       $data =  InfluncerCategory::create($addTranslate);
       $data->addMedia($request->file('image'))
       ->toMediaCollection('influncerCategories');
        activity()->log('Admin "'.Auth::user()->name.'" Added "'. $data->name .'" Influncer Category');
        Alert::toast('Influncer Category was added', 'success');

        return redirect()->route('dashboard.influencerCategories.index');
    }

    public function update(InfluncerCategoryRequest $request,$id)
    {
        $data = InfluncerCategory::find($id);
        $data->update($request->all());   
        if($request->hasFile('image'))
        {
            $data
            ->clearMediaCollection('influncerCategories')
            ->addMedia($request->file('image'))
            ->toMediaCollection('influncerCategories');
        }        
        activity()->log('Admin "'.Auth::user()->name.'" update "'. $data->name .'" Influncer Category');
        Alert::toast('Influncer Category was updated', 'success');
        return redirect()->route('dashboard.influencerCategories.index');
    }

    public function delete($id)
    {
        $data = InfluncerCategory::find($id);
        foreach ($data->categories as $key => $value) {
            $data->categories()->detach($value)
            ->save();
        }
        $data->influncers()->detach();
        $data->delete();

        activity()->log('Admin "'.Auth::user()->name.'" deleted "'. $data->name .'" Influncer Category');
        Alert::toast('Influncer Category was deleted', 'success');

        return response()->json([
            'status'=>200,
            'msg'=>'Influncer Category was deleted'
        ],200);
    }
}
