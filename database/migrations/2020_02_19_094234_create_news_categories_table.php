<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('seo_keyword', 255);
            $table->string('seo_description', 255);
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
        Schema::drop('news_categories');
    }
}
