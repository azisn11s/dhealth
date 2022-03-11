<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRacikanObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racikan_obat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('racikan_id')->index();
            $table->integer('obat_id')->index();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('racikan_id')->references('id')->on('resep_racikan');
            $table->foreign('obat_id')->references('obatalkes_id')->on('obatalkes_m');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('racikan_obat');
    }
}
