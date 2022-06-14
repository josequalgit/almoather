<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\InfluncerCategory;

class CategoryController extends Controller
{
    private $trans_dir = 'messages.api.';

    public function index()
    {
        $serviceCat = Category::where('type','service')->select(['id','name'])->get();
        $productCat = Category::where('type','product')->select(['id','name'])->get();

        return response()->json([
            'msg'=>trans($this->trans_dir.'product_categories_available'),
            'data'=>[
                'service'=>$serviceCat,
                'product'=>$productCat
            ],
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function getInfluncerCategories()
    {
        $data = InfluncerCategory::select(['id','name'])->get()->map(function($item){
            return[
                'id'=>$item->id,
                'name'=>$item->name
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'influencer_categories_available'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }

    public function search($query)
    {
        $data = InfluncerCategory::where('name','LIKE',"%$query%")->paginate(config('global.PAGINATION_NUMBER'));
      $data->getCollection()->transform(function($item){
            return[
                'id'=>$item->id,
                'name'=>$item->name,
            ];
        });

        return response()->json([
            'msg'=>trans($this->trans_dir.'search_result_for_the_categories'),
            'data'=>$data,
            'status'=>config('global.OK_STATUS')
        ],config('global.OK_STATUS'));
    }
}
