<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanDefaultAdvantagesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function($table) {
            $table->boolean('order_meal')->default(0);
            $table->boolean('reserve')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function($table) {
          $table->dropColumn('order_meal');
          $table->dropColumn('reserve');
        });
    }
}
