<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterNewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('canonical')->nullable(); 
            $table->timestamp('public_at')->nullable();
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
