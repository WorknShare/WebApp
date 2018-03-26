<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentForeignClientPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->integer('id_client')->unsigned();
            $table->integer('id_plan')->unsigned();
            $table->foreign('id_client')
                  ->references('id_client')
                  ->on('clients')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('id_plan')
                  ->references('id_plan')
                  ->on('plans')
                  ->onDelete('restrict')
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
        Schema::table('history', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            $table->dropColumn('id_client');
            $table->dropForeign(['id_plan']);
            $table->dropColumn('id_plan');
        });
    }
}
