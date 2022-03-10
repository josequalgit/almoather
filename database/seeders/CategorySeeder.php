<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\InfluncerCategory;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'=>'Sport',
                'type'=>'service',
                'influncer_category_id'=>1
            ],
            [
                'name'=>'Entertainment',
                'type'=>'product',
                'influncer_category_id'=>1
            ],
			 [
                'name'=>'Test',
                'type'=>'product',
                'influncer_category_id'=>1
            ]
        ];
        foreach ($data as $item) {
          $cat =   Category::create($item);
          $url = \URL::to('').'/img/products/1.png';
          $cat->addMediaFromUrl($url)
          ->toMediaCollection('categories');
        };

        $data2 = [
            [
                'name'=>'BaseBall'
            ],
            [
                'name'=>'Movies'
            ],
			 [
                'name'=>'Games'
            ],
        ];
        foreach($data2 as $item)
        {
            $cat = InfluncerCategory::create($item);
            $url = \URL::to('').'/img/products/1.png';
            $cat->addMediaFromUrl($url)
            ->toMediaCollection('influncerCategories');
        }
    }
}
