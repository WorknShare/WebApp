<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_meal', function (Blueprint $table) {
            $table->integer('id_site')->unsigned();
            $table->integer('id_meal')->unsigned();
            $table->primary(['id_site','id_meal']);
            $table->foreign('id_site')
                  ->references('id_site')
                  ->on('sites')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_meal')
                  ->references('id_meal')
                  ->on('meals')
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
        Schema::dropIfExists('site_meal');
    }
}
