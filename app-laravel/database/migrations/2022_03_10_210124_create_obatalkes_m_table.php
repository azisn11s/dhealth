<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateObatalkesMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = 'seeds/external_sql/obatalkes_m_ddl.sql';
        DB::unprepared(file_get_contents(database_path($path)));
        // $this->command->info('Obat table seeded!');

        // Schema::create('obatalkes_m', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obatalkes_m');
    }
}
