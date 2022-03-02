<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\InfluncerCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $serviceCat = Category::where('type','service')->select(['id','name'])->get();
        $productCat = Category::where('type','product')->select(['id','name'])->get();

        return response()->json([
            'msg'=>'the product categories available',
            'service'=>$serviceCat,
            'product'=>$productCat,
            'status'=>200
        ],200);
    }

    public function getInfluncerCategories()
    {
        $data = InfluncerCategory::select(['id','name'])->get();

        return response()->json([
            'msg'=>'the influncer categories available',
            'data'=>$data
        ]);
    }
}
