<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHistoryPaymentInfoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add the payment information columns
        Schema::table('history', function (Blueprint $table) {
            $table->string('name', 25);
            $table->string('surname', 25);
            $table->string('phone', 10);
            $table->string('address');
            $table->string('city');
            $table->string('postal', 5);
            $table->string('credit_card_number', 16);
            $table->string('csc', 3);
            $table->date('expiration');
            $table->timestamps();
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
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('postal');
            $table->dropColumn('credit_card_number');
            $table->dropColumn('csc');
            $table->dropColumn('expiration');
            $table->dropTimestamps();
        });
    }
}
