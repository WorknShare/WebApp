<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeReserveRoomPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reserve_room');
        Schema::create('reserve_room', function (Blueprint $table) {
            $table->increments('id_reserve_room');
            $table->integer('id_client')->unsigned();
            $table->integer('id_room')->unsigned();
            $table->datetime('date_start');
            $table->datetime('date_end'); 
            $table->foreign('id_client')
                  ->references('id_client')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_room')
                  ->references('id_room')
                  ->on('rooms')
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
        Schema::dropIfExists('reserve_room');
        Schema::create('reserve_room', function (Blueprint $table) {
            $table->integer('id_client')->unsigned();
            $table->integer('id_room')->unsigned();
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->primary(['id_client','id_room']);
            $table->foreign('id_client')
                  ->references('id_client')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_room')
                  ->references('id_room')
                  ->on('rooms')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
