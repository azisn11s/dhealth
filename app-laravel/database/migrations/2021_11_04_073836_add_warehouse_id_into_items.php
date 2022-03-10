<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarehouseIdIntoItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_id')->index();
            $table->unsignedBigInteger('unit_id')->index();

            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_warehouse_id_foreign');
            $table->dropForeign('items_unit_id_foreign');
            $table->dropColumn('warehouse_id');
            $table->dropColumn('unit_id');
        });
    }
}
