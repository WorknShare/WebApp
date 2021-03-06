<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteClientMealOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('client_meal_orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::create('client_meal_orders', function (Blueprint $table) {
          $table->integer('id_client')->unsigned();
          $table->integer('id_meal')->unsigned();
          $table->integer('id_site')->unsigned();
          $table->string('command_number');
          $table->datetime('hour');
          $table->boolean('is_deleted')->default(0);
          $table->primary(['id_client','id_meal', 'id_site']);
          $table->foreign('id_client')
                ->references('id_client')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
          $table->foreign('id_meal')
                ->references('id_meal')
                ->on('meals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
          $table->foreign('id_site')
                ->references('id_site')
                ->on('sites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
      });
    }
}
