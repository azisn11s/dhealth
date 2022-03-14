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
        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(FeaturesTableSeeder::class);

        // Requirements
        $this->call(ObatTableMigrationSeeder::class);
        $this->call(SignaTableMigrationSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
