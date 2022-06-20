<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Request;

class CountriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
    * @return void
     */
    public function run()
    {
        $json = file_get_contents(Request::url().'/countries.json');
        foreach ($json as $value) {
            Country::create([
                'name'=>[
                    'ar'=>'',
                    'en'=>$value->name
                ],
                'country_code'=>'000',
                'code'=>$value->code,
                'is_location'=>1
            ]);
        }

    }
}
