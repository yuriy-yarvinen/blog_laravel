<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleContentJsonToBlogpostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogpost', function (Blueprint $table) {
			$table->string('title')->default('');
			if (env('DB_CONNECTION') === 'sqlite_test') {
				$table->text('content')->default('');
				$table->json('json')->default('');	
			}
			else{
				$table->text('content');
				$table->json('json');	
			}				
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogpost', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');
            $table->dropColumn('json');
        });
    }
}
