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
                'name'=>'Facebook',
                'logo'=>\URL::to('').'/img/media/facebook.png'
            ],
            [
                'name'=>'Twitter',
                  'logo'=>\URL::to('').'/img/media/twitter.png'
            ],
            [
                'name'=>'Instagram',
                  'logo'=>\URL::to('').'/img/media/instagram.png'
            ],
            [
                'name'=>'Snapchat',
                  'logo'=>\URL::to('').'/img/media/snapchat.png'
            ],
            [
                'name'=>'Youtube',
                  'logo'=>\URL::to('').'/img/media/youtube.png'
            ],
            [
                'name'=>'Tiktok',
                  'logo'=>\URL::to('').'/img/media/tiktok.png'
            ]
        ];
  

      

        foreach ($data as $key => $value) {
          $media = SocialMedia::create([
                'name'=>$value['name']
            ]);
            $media->addMediaFromUrl($value['logo'])
            ->toMediaCollection('logos');
        }
    }
}
