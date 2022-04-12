<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CampaignGoal;

class CampaignGoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = 
        [
            [
                'title'=>[
                    'ar'=>'Goal Number 1',
                    'en'=>'Goal Number 1'
                ]
            ],
            [
                'title'=>[
                    'ar'=>'Goal Number 2',
                    'en'=>'Goal Number 2'
                ]
            ],
            [
                'title'=>[
                    'ar'=>'Goal Number 3',
                    'en'=>'Goal Number 3'
                ]
            ],
            [
                'title'=>[
                    'ar'=>'Goal Number 4',
                    'en'=>'Goal Number 4'
                ]
            ]
        ];
        foreach ($data as $value) {
            CampaignGoal::create($value);
        }
    }
}
