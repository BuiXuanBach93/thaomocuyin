<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail');
            $table->string('thumbnail_home');
            $table->string('description');
            $table->text('content');
            $table->string('seo_title');
            $table->string('seo_keyword');
            $table->string('seo_description');
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
        Schema::drop('news');
    }
}
