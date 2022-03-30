<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(1);
        $user = User::create([
            'name'=>'Super Admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt(123456)
        ]);
        $user->assignRole($role);

    }
}
