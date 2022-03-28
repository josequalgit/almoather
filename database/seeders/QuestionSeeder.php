<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
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
                'title'=>[
                    'ar'=>'السؤال في اللغة العربية',
                    'en'=>'question in arabic',
                ]
            ],
            [
                'title'=>[
                    'ar'=>'1السؤال في اللغة العربية',
                    'en'=>'question in arabic2',
                ]
            ],
            [
                'title'=>[
                    'ar'=>'2السؤال في اللغة العربية',
                    'en'=>'question in arabic3',
                ]
            ],
            [
                'title'=>[
                    'ar'=>'3السؤال في اللغة العربية',
                    'en'=>'question in arabic4',
                ]
            ],
        ];

        foreach ($data as $value) {
            Question::create($value);
        }
    }
}
