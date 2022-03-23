<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFanpagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fanpages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fanpage_id');
            $table->tinyinteger('status');
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
        Schema::drop('fanpages');
    }
}
