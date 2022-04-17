<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email'=>'ahmed@gmail.com',
            'password'=>bcrypt(123456),
            'phone'=>'002490489878'
        ]);

        $customer = Customer::create([
            'full_name'=>'Ahmed',
            'country_id'=>1,
            'region_id'=>1,
            'nationality_id'=>1,
            'city_id'=>1,
            'user_id'=>$user->id,
        ]);
        $url = \URL::to('').'/img/products/1.png';

        $user->addMediaFromUrl($url)
        ->toMediaCollection('customers');


    }
}
