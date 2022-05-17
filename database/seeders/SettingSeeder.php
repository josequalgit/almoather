<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AppSetting;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'ar'=>'عربي',
                'en'=>'En Text'
            ],
            [
                'ar'=>'عربي',
                'en'=>'En Text2'
            ]
        
        ];
        AppSetting::create([
            'key'=>'Campaign Goal',
            'value'=>json_encode($array)
        ]);
        AppSetting::create([
            'key'=>'Customer Contract',
            'value'=>json_encode('This contract content it just for a test if to show you how it will look like in the mobile')
        ]);

        AppSetting::create([
            'key'=>'Influencer Contract',
            'value'=>json_encode('This contract content it just for a test if to show you how it will look like in the mobile')
        ]);
    }
}
