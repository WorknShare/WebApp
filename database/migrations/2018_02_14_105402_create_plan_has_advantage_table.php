<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanHasAdvantageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_has_advantage', function (Blueprint $table) {
            $table->integer('id_plan')->unsigned();
            $table->integer('id_plan_advantage')->unsigned();
            $table->foreign('id_plan')
                  ->references('id_plan')
                  ->on('plans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_plan_advantage')
                  ->references('id_plan_advantage')
                  ->on('plan_advantages')
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
        Schema::dropIfExists('plan_has_advantage');
    }
}
