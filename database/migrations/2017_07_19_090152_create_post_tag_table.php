<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('tag_id')->unsigned();
          $table->integer('post_id')->unsigned();
        });

        Schema::table('post_tag', function($table) {   
          $table->foreign('tag_id')
              ->references('id')
              ->on('tags');
          $table->foreign('post_id')
              ->references('id')
              ->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExist('post_tag');
    }
}
