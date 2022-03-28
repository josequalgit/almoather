<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Region;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name'=>'Saudi Arabia',
            'code'=>'966'
        ]);

        Region::create([
            'name'=>'Eastern Region',
            'country_id'=>1
        ]);
    }
}
