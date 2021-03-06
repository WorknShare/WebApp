<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplacePaymentDurationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->datetime('limit_date');
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
            $table->dropColumn('limit_date');
            $table->datetime('duration')->nullable();
        });
    }
}
