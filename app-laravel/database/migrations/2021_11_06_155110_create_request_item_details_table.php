<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_item_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_item_id')->index();
            $table->unsignedBigInteger('item_id')->index();
            $table->double('quantity');
            $table->string('caption')->nullable();
            $table->string('status')->index();
            
            $table->timestamps();
            $table->foreign('request_item_id')->references('id')->on('request_items');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('status')->references('status')->on('request_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_item_details');
    }
}
