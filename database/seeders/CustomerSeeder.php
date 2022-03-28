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
            'password'=>bcrypt(123456)
        ]);

        $customer = Customer::create([
            'first_name'=>'Ahmed',
            'last_name'=>'Khaled',
            'phone'=>'0759545482',
            'country_id'=>1,
            'region_id'=>1,
            'id_number'=>'6554664',
            'nationality_id'=>1,
            'city_id'=>1,
            'user_id'=>$user->id,
            'commercial_registration_no'=>'1235',
            'tax_registration_number'=>'1235'
        ]);
        $url = \URL::to('').'/img/products/1.png';

        $user->addMediaFromUrl($url)
        ->toMediaCollection('customers');


    }
}
