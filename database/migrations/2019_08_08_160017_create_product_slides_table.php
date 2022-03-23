<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSlidesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->tinyInteger('is_main');
            $table->string('name', 255);
            $table->string('alt', ßßßßß255);
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
        Schema::drop('product_slides');
    }
}
