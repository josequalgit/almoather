<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\InfluncerCategory;
use App\Http\Traits\UploadFiles;

use Auth , Alert;

class CategoryController extends Controller
{
    use UploadFiles;

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
        $excludeCategories = $data->excludeCategories->pluck('id')->toArray();
        return view('dashboard.categories.edit',compact('data','categories','excludeCategories'));
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

       $data->excludeCategories()->sync($request->exclude_categories);

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
    
        
        $data->excludeCategories()->sync($request->exclude_categories);
           
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
