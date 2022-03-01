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
        return view('dashboard.categories.create',compact('data'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        $categories = InfluncerCategory::get();

        return view('dashboard.categories.edit',compact('data','categories'));
    }

    public function store(CategoryRequest $request)
    {
       $data =  Category::create($request->all());
       $data->addMedia($request->file('image'))
       ->toMediaCollection('categories');
    
        activity()->log('Admin "'.Auth::user()->name.'" Added '. $data->name .' category');
        Alert::toast('Category was added', 'success');

        return redirect()->route('dashboard.categories.index');
    }

    public function update(UpdateCategoryRequest $request,$id)
    {
        $data = Category::find($id);
        $data->update($request->all());     
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
