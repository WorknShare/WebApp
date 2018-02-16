<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientPlanColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function($table) {
            $table->integer('id_plan')->unsigned();
            $table->foreign('id_plan')
                  ->references('id_plan')
                  ->on('plans')
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
        Schema::table('clients', function($table) {
            $table->dropForeign(['id_plan']);
            $table->dropColumn('id_plan');
        });
    }
}
