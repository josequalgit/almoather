<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            ContactUsSeeder::class,
            SocialMediaSeeder::class,
            PrivaciesTermsSeeder::class,
            // CountrySeeder::class,
            CitySeeder::class,
            AreaSeeder::class,
            CategorySeeder::class,
            ContractSeeder::class,
            AddressSeeder::class,
            BankSeeder::class,
            QuestionSeeder::class,
            RattingSeeder::class,
            SettingSeeder::class,
            CampaignGoalsSeeder::class,
            CountriesSeed::class
            // CustomerSeeder::class,
            // AdSeeder::class,
            // InfulencerSeeder::class,
        ]);
    }
}
