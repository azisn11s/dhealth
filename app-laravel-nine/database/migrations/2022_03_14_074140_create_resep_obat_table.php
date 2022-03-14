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
        Schema::create('resep_obat', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('resep_id')->index();
            $table->string('entity_type', 20)->index();
            $table->unsignedBigInteger('entity_id')->index();

            $table->primary(['resep_id', 'entity_type', 'entity_id']);
            $table->foreign('resep_id')->references('id')->on('resep');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_obat');
    }
};
