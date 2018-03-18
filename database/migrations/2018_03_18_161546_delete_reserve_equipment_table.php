<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteReserveEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reserve_equipment');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('reserve_equipment', function (Blueprint $table) {
            $table->integer('id_client')->unsigned();
            $table->integer('id_equipment')->unsigned();
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->primary(['id_client','id_equipment']);
            $table->foreign('id_client')
                  ->references('id_client')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_equipment')
                  ->references('id_equipment')
                  ->on('equipment')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
