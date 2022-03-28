<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;
class AddressSeeder extends Seeder
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
                'name'=>'Test,st,saudi arabia',
                'country_id'=>1
            ]
        ];
        foreach ($data as $item) {
            Address::create($item);
        }
       
    }
}
