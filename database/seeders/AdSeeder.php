<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;
use Carbon\Carbon;
use DB;
class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $ad =  Ad::create([
        'type'=>'service',
        'store'=>'Lenovo',
        'ad_type'=>'onsite',
        'marouf_num'=>'035493',
        'store_link'=>'www.sd.com',
        'cr_num'=>'249516',
        'about'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        'scenario'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        'budget'=>'10000',
        'country_id'=>1,
        'city_id'=>1,
        'area_id'=>1,
        'customer_id'=>1,
        'category_id'=>1,        
        ]);

        DB::table('influncer_influncer_category')->insert([
            'influncer_category_id'=>'1',
            'influncer_id'=>'1',
        ]);
        
        $url = \URL::to('').'/img/products/1.png';
        $ad->addMediaFromUrl($url)
        ->toMediaCollection('adImage');

        

    }
}
