<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepRacikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_racikan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_racikan');
            $table->integer('signa_id')->index();
            $table->timestamps();

            $table->foreign('signa_id')->references('signa_id')->on('signa_m');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_racikan');
    }
}
