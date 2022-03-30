<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactUs;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactUs::create([
            'name'=>'Admin',
            'title'=>'Contact Us Test',
            'message'=>'This is a long text to test the page',
            'email'=>'admin@admin.com',
        ]);
    }
}
