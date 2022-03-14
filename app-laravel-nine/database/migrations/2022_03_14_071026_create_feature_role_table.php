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
        Schema::create('feature_role', function (Blueprint $table) {
            $table->string('feature_slug', 30)->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->json('abilities')->nullable();

            $table->foreign('feature_slug')->references('slug')->on('features');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_role');
    }
};
