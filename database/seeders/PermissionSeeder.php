<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'See Logs',
            'Edit Admin',
            'See Ads',
            'Edit Ads',
            'Create Admin',
            'See Admin',
            'Delete Admin',
            'Edit Influncer',
            'See Influncer',
            'Edit Customer',
            'Create Customer',
            'See Customer',
            'See Customer Ads',
            'Delete Customer',
            'Edit Role',
            'Create Role',
            'See Role',
            'Delete Role',
            'Edit Notification',
            'Create Notification',
            'See Notification',
            'Delete Notification',
            'Edit Contact Us',
            'Create Category',
            'See Category',
            'Delete Category',
            'Edit Category',
            'Create Influencer Category',
            'See Influencer Category',
            'Delete Influencer Category',
            'Edit Influencer Category',
            'See SocialMedia',
            'Edit SocialMedia',
            'Edit Terms',
            'Edit Privacy',
            'Create Faq',
            'See Faq',
            'Delete Faq',
            'Edit Faq',
            
        ];

        foreach ($permissions as $key => $value) {
            $checkPermission = Permission::where('name',$value)->first();
            if(!$checkPermission) Permission::create(['name'=>$value]);
        }
    }
}
