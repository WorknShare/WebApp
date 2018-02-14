<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id_room');
            $table->string('place');
            $table->string('name');
            $table->integer('id_site')->unsigned();
            $table->integer('id_room_type')->unsigned();
            $table->foreign('id_site')
                  ->references('id_site')
                  ->on('sites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_room_type')
                  ->references('id_room_type')
                  ->on('room_types')
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
        Schema::dropIfExists('rooms');
    }
}
