<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletingToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
			if (env('DB_CONNECTION') !== 'sqlite_test') {
				$table->dropForeign(['blog_post_id']);
			}
			
			$table->foreign('blog_post_id')
				->references('id')
				->on('blog_posts')
				->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
			// $table->dropForeign('comments_blog_post_id_index');
			$table->dropForeign(['blog_post_id']);
			$table->foreign('blog_post_id')
				->references('id')
				->on('blog_posts');
        });
    }
}
