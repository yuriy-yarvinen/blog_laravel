<?php
namespace App;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    static function up($id)
    {
        Schema::create("user_$id"."_statistic_table", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
        Schema::create("user_$id"."_keys_table", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    static function down($id)
    {
        Schema::dropIfExists("user_$id"."_statistic_table");
        Schema::dropIfExists("user_$id"."_keys_table");
    }
}
