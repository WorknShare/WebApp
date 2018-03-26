<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveClientHistoryPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('client_history_plan');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('client_history_plan', function (Blueprint $table) {
            $table->integer('id_client')->unsigned();
            $table->integer('id_plan')->unsigned();
            $table->integer('id_history')->unsigned();
            $table->primary(['id_client','id_plan', 'id_history']);
            $table->foreign('id_client')
                  ->references('id_client')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_plan')
                  ->references('id_plan')
                  ->on('plans')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_history')
                  ->references('id_history')
                  ->on('history')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
