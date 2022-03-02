<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'superAdmin',
        ];
        $permissions = Permission::get();

        foreach ($roles as $key => $value) {
            $role = null;
            $role = Role::where('name',$value)->first();
            if(!$role) $role = Role::create(['name' => $value]);
           $role->permissions()->detach();
           foreach ($permissions as $key => $value) {
            $role->givePermissionTo($value);
           }
        }
    }
}
