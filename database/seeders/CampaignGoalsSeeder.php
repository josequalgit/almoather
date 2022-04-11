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
                'title'=>'Goal Number 1'
            ],
            [
                'title'=>'Goal Number 2'
            ],
            [
                'title'=>'Goal Number 3'
            ],
            [
                'title'=>'Goal Number 4'
            ]
        ];
        foreach ($data as $value) {
            CampaignGoal::create($value);
        }
    }
}
