<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReserveEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_equipment', function (Blueprint $table) {
          $table->integer('id_equipment')->unsigned();
          $table->integer('id_reserve_room')->unsigned();
          $table->primary(['id_equipment','id_reserve_room']);
          $table->foreign('id_equipment')
                ->references('id_equipment')
                ->on('equipment')
                ->onDelete('cascade')
                ->onUpdate('cascade');
          $table->foreign('id_reserve_room')
                ->references('id_reserve_room')
                ->on('reserve_room')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_equipment');
    }
}
