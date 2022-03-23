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
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->integer('category_id');
            $table->string('thumbnail', 255);
            $table->string('description', 255);
            $table->string('content');
            $table->string('seo_title', 255);
            $table->string('seo_keyword', 255);
            $table->string('seo_description', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product');
    }
}
