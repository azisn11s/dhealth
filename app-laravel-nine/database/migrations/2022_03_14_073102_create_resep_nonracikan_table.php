<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_nonracikan', function (Blueprint $table) {
            $table->id();
            $table->integer('obat_id')->index();
            $table->integer('signa_id')->index();
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table->foreign('obat_id')->references('obatalkes_id')->on('obatalkes_m');
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
        Schema::dropIfExists('resep_nonracikan');
    }
};
