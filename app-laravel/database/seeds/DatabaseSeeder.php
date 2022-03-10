<?php

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
        $this->call(RequestStatusSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        
        // Opt
        $this->call(EmployeeTableSeeder::class);
        $this->call(WarehouseTableSeeder::class);
        $this->call(ItemTableSeeder::class);


    }
}
