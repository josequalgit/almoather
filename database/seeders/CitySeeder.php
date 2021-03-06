<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name'=>[
                'ar'=>'جده',
                'en'=>'Jeddah'
            ],
            'region_id'=>'1',
            'area_id'=>'1'
        ]);
    }
}
