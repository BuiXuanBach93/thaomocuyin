<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Createadmin.fb-postsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('fanpage_id');
            $table->string('keyword');
            $table->tinyInteger('status');
            $table->string('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fb_posts');
    }
}
