<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatTableMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'seeders/external_sql/obatalkes_m_seed.sql';
        DB::unprepared(file_get_contents(database_path($path)));
        $this->command->info('Obat table seeded!');
    }
}
