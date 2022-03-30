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
                'name'=>[
                    'ar'=>'رياضة',
                    'en'=>'Sport'
                ],
                'type'=>'service',
            ],
            [
                'name'=>[
                    'ar'=>'ترفيه',
                    'en'=>'Entertainment'
                ],
                'type'=>'product'
            ],
            [
                'name'=>[
                    'ar'=>'تجربه1',
                    'en'=>'Test1'
                ],
                'type'=>'service',
            ],
            [
                'name'=>[
                    'ar'=>'تجربه2',
                    'en'=>'Test2'
                ],
                'type'=>'product'
            ]
        ];
        foreach ($data as $item) {
          $cat =   Category::create($item);
          //$cat->preferredCategories()->attach(1);
          $cat->excludeCategories()->attach(2);
          $url = \URL::to('').'/img/products/1.png';
          $cat->addMediaFromUrl($url)
          ->toMediaCollection('categories');
        };

        $data2 = [
            [
                'name'=>[
                    'ar'=>'بيس بول',
                    'en'=>'BaseBall'
                ]
            ],
            [
                'name'=>[
                    'ar'=>'افلام',
                    'en'=>'Movies'
                ]
            ],
            [
                'name'=>[
                    'ar'=>'2بيس بول',
                    'en'=>'BaseBall2'
                ]
            ],
            [
                'name'=>[
                    'ar'=>'2افلام',
                    'en'=>'Movies2'
                ]
            ]
        ];
        foreach($data2 as $item)
        {
            $cat = InfluncerCategory::create($item);
           // $cat->categories()->attach(1);
            $url = \URL::to('').'/img/products/1.png';
            $cat->addMediaFromUrl($url)
            ->toMediaCollection('influncerCategories');
        }
    }
}
