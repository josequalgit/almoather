<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;
class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contract::create([
            'title'=>'This is just a test contract name',
            'content'=>'This contract content it just for a test if to show you how it will look like in the mobile',
        ]);
        Contract::create([
            'title'=>'This is just a test contract name',
            'content'=>'This contract content it just for a test if to show you how it will look like in the mobile',
            'ad_id'=>1
        ]);
    }
}
