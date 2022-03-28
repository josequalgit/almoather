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
        'budget'=>'5000',
        'auth_number'=>'0546886246',
        'onSite'=>1,
        'date'=>Carbon::now(),
        'about'=>"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
        'status'=>'pending',
        'social_media_id'=>1,
        'country_id'=>1,
        'city_id'=>1,
        'area_id'=>1,
        'customer_id'=>1,
        'website_link'=>'https://www.lenovo.com/jo/en/',
        'media_account_id'=>1,
        'nearest_location'=>'Amman',
        
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
