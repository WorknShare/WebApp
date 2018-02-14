<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id_ticket');
            $table->integer('status');
            $table->text('description');
            $table->integer('id_employee_src')->unsigned();
            $table->integer('id_employee_assigned')->unsigned()->nullable();
            $table->integer('id_equipment')->unsigned();
            $table->timestamps();
            $table->foreign('id_employee_src')
                  ->references('id_employee')
                  ->on('employees')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_employee_assigned')
                  ->references('id_employee')
                  ->on('employees')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('id_equipment')
                  ->references('id_equipment')
                  ->on('equipment')
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
        Schema::dropIfExists('tickets');
    }
}
