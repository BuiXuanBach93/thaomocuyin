<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function($table) {
            $table->integer('price');
            $table->string('color', 255);
            $table->tinyInteger('discount_type');
            $table->float('discount');
            $table->string('notes', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function($table) {
            $table->dropColumn('price');
            $table->dropColumn('color');
            $table->dropColumn('discount_type');
            $table->dropColumn('discount');
            $table->dropColumn('notes');
        });
    }
}
