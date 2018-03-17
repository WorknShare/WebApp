<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipmentIsDeletedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment_types', function($table) {
            $table->boolean('is_deleted')->default(0);
        });
        Schema::table('equipment', function($table) {
            $table->boolean('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_types', function($table) {
          $table->dropColumn('is_deleted');
        });
        Schema::table('equipment', function($table) {
          $table->dropColumn('is_deleted');
        });
    }
}
