<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InfluencerRateing;

class RattingSeeder extends Seeder
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
                'question_id'=>1,
                'ad_id'=>1,
                'influencer_id'=>1,
                'rate'=>1
            ],
        ];
        foreach ($data as $key => $value) {
            InfluencerRateing::create($value);
        }
    }
}
