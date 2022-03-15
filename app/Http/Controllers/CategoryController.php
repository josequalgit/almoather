<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\InfluncerCategory;

use Alert;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::paginate(10);

        return view('dashboard.categories.index',compact('data'));
    }

    public function create()
    {
        $data = InfluncerCategory::get();
        $categories = InfluncerCategory::get();

        return view('dashboard.categories.create',compact('data','categories'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        $categories = InfluncerCategory::get();
        $preferredCategories = $data->preferredCategories->pluck('id')->toArray();
        $excludeCategories = $data->excludeCategories->pluck('id')->toArray();
        return view('dashboard.categories.edit',compact('data','categories','preferredCategories','excludeCategories'));
    }

    public function store(CategoryRequest $request)
    {
        $addTranslate = [
            'name'=>[
                'ar'=>$request->name_ar,
                'en'=>$request->name_en,
            ],
            'type'=>$request->type,
        ];
       $data =  Category::create($addTranslate);
       $data->addMedia($request->file('image'))
       ->toMediaCollection('categories');

       foreach ($request->preferred_categories as $value) {
        $data->preferredCategories()->attach($value);
        }   
    //    foreach ($request->influncer_category_id as $value) {
    //       $data->influncerCategories()->attach($value);
    //    }    
       foreach ($request->exclude_categories as $value) {
          $data->excludeCategories()->attach($value);
       }    

        activity()->log('Admin "'.Auth::user()->name.'" Added '. $data->name .' category');
        Alert::toast('Category was added', 'success');

        return redirect()->route('dashboard.categories.index');
    }

    public function update(UpdateCategoryRequest $request,$id)
    {
        $addTranslate = [
            'name'=>[
                'ar'=>$request->name_ar,
                'en'=>$request->name_en,
            ],
            'type'=>$request->type,
        ];
        $data = Category::find($id);
        $data->update($addTranslate); 
      //  $data->influncerCategories()->detach();
        $data->preferredCategories()->detach();
        $data->excludeCategories()->detach();
        // foreach ($request->influncer_category_id as $value) {
        //    $data->influncerCategories()->attach($value);
        // }    
        foreach ($request->preferred_categories as $value) {
           $data->preferredCategories()->attach($value);
        }    
        foreach ($request->exclude_categories as $value) {
            $data->excludeCategories()->attach($value);
        }    
        if($request->hasFile('image'))
        {
            $data
            ->clearMediaCollection('categories')
            ->addMedia($request->file('image'))
            ->toMediaCollection('categories');
        }   
        activity()->log('Admin "'.Auth::user()->name.'" update "'. $data->name .'" category');
        Alert::toast('Category was updated', 'success');
        return redirect()->route('dashboard.categories.index');
    }

    public function delete($id)
    {
        $data = Category::find($id);
        // foreach($data->prodocts as $item)
        // {
        //     $data->prodocts()->detach($item)
        //     ->save();
        // }
        $data
        ->clearMediaCollection('categories')
        ->influncerCategories()->dissociate()
        ->delete();

        activity()->log('Admin "'.Auth::user()->name.'" deleted "'. $data->name .'" category');
        Alert::toast('Category was deleted', 'success');
        
        return response()->json([
            'status'=>200,
            'msg'=>'category was deleted'
        ],200);
    }
}
