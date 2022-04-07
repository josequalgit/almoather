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
                'en'=>'En Text'
            ]
        
        ];
        AppSetting::create([
            'key'=>'Campaign Goal',
            'value'=>json_encode($array)
        ]);
    }
}
