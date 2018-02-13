<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_schedules', function (Blueprint $table) {
            $table->increments('id_schedule');
            $table->integer('day')->unsigned();
            $table->timeTz('hour_opening');
            $table->timeTz('hour_closing');
            $table->integer('id_site')->unsigned();
            $table->foreign('id_site')
                ->references('id_site')
                ->on('sites')
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
        Schema::dropIfExists('site_schedules');
    }
}
