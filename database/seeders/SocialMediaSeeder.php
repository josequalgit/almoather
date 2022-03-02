<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialMedia;

class SocialMediaSeeder extends Seeder
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
                'name'=>'Facebook'
            ],
            [
                'name'=>'Twitter'
            ],
            [
                'name'=>'Instagram'
            ],
            [
                'name'=>'Snapchat'
            ],
            [
                'name'=>'Youtube'
            ],
            [
                'name'=>'Tiktok'
            ]
        ];
        foreach ($data as $key => $value) {
            SocialMedia::create([
                'name'=>$value['name']
            ]);
        }
    }
}
