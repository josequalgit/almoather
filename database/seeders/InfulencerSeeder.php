<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Influncer;
use Carbon\Carbon;

class InfulencerSeeder extends Seeder
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
                'full_name'=>[
                    'en'=>'Ahmed from seeder',
                    'ar'=>'احمد من السيدير'
                ],
                'nick_name'=>'7modh',
                'bank_name'=>'Al-at7ad',
                'bank_account_number'=>'005648002564',
                'bio'=>'This is my full bio',
                'ads_out_country'=>1,
                'city_id'=>1,
                'country_id'=>1,
                'nationality_id'=>1,
                'region_id'=>1,
                'user_id'=>2,
                'is_vat'=>1,
                'ad_price'=>354,
                'ad_onsite_price'=>234,
                'id_number'=>'00928989473',
                'phone'=>'0929912308',
                'ad_with_vat'=>'12354',
                'ad_onsite_price_with_vat'=>123,
                'birthday'=>Carbon::now(),
                'address_id'=>1,
                'bank_id'=>1,
                'snap_chat_views'=>1,
                'commercial_registration_no'=>'123123',
                'tax_registration_number'=>'123123',
                'rep_full_name'=>'this is a full name',
                'rep_id_number_name'=>'123556',
                'rep_phone_number'=>'123556',
                'rep_email'=>'email@gmail.com',
            ],
            [
                'full_name'=>[
                    'en'=>'Mohammad from seeder',
                    'ar'=>'محمد من السيدير'
                ],
                'nick_name'=>'7madh',
                'bank_name'=>'Al-at7ad',
                'bank_account_number'=>'005648002564',
                'bio'=>'This is my full bio',
                'ads_out_country'=>1,
                'city_id'=>1,
                'country_id'=>1,
                'nationality_id'=>1,
                'region_id'=>1,
                'user_id'=>3,
                'is_vat'=>1,
                'ad_price'=>354,
                'ad_onsite_price'=>234,
                'id_number'=>'00928989473',
                'phone'=>'0929912308',
                'ad_with_vat'=>'12354',
                'ad_onsite_price_with_vat'=>123,
                'birthday'=>Carbon::now(),
                'address_id'=>1,
                'bank_id'=>1,
                'snap_chat_views'=>1,
                'commercial_registration_no'=>'123123',
                'tax_registration_number'=>'123123',
                'rep_full_name'=>'this is a full name',
                'rep_id_number_name'=>'123556',
                'rep_phone_number'=>'123556',
                'rep_email'=>'email@gmail.com',
            ],
            [
                'full_name'=>[
                    'en'=>'Leth from seeder',
                    'ar'=>'ليث من السيدير'
                ],
                'nick_name'=>'Abu-najem',
                'bank_name'=>'Al-at7ad',
                'bank_account_number'=>'005648002564',
                'bio'=>'This is my full bio',
                'ads_out_country'=>1,
                'city_id'=>1,
                'country_id'=>1,
                'nationality_id'=>1,
                'region_id'=>1,
                'user_id'=>4,
                'is_vat'=>1,
                'ad_price'=>354,
                'ad_onsite_price'=>234,
                'id_number'=>'00928989473',
                'phone'=>'0929912308',
                'ad_with_vat'=>'12354',
                'ad_onsite_price_with_vat'=>123,
                'birthday'=>Carbon::now(),
                'address_id'=>1,
                'bank_id'=>1,
                'snap_chat_views'=>1,
                'commercial_registration_no'=>'123123',
                'tax_registration_number'=>'123123',
                'rep_full_name'=>'this is a full name',
                'rep_id_number_name'=>'123556',
                'rep_phone_number'=>'123556',
                'rep_email'=>'email@gmail.com'
            ]
        ];
        $users = [
            [
                'name'=>'7modh',
                'email'=>'7modh@email.com',
                'password'=>bcrypt(123456)
            ],
            [
                'name'=>'7madh',
                'email'=>'7madh@email.com',
                'password'=>bcrypt(123456)
            ],
            [
                'name'=>'leth',
                'email'=>'leth@email.com',
                'password'=>bcrypt(123456)
            ],
        ];
        $new_created_users = [];


        foreach ($users as $value) {
            $user = User::create($value);
           array_push($new_created_users,$user);
        }
        foreach ($data as $key => $value) {
           $edited_data = array_merge($value,['user_id'=>$new_created_users[$key]->id]);
           Influncer::create($edited_data);
        }
    }
}
