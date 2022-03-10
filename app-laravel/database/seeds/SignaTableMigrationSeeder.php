<?php

use Illuminate\Database\Seeder;

class SignaTableMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'seeds/external_sql/signa_m.sql';
        DB::unprepared(file_get_contents(database_path($path)));
        $this->command->info('Signa table seeded!');
    }
}
