<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LanguageSeeder::class);
        // Load roles
        $this->call(RolesTableSeeder::class);

        // load users
        $this->call(UsersTableSeeder::class);

        // load notification settings
        $this->call(NotificationSettingSeeder::class);

    }
}
