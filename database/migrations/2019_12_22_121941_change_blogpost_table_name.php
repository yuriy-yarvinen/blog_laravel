<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBlogpostTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('blogpost','blog_posts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
				Schema::rename('blog_posts','blogpost');
    }
}
