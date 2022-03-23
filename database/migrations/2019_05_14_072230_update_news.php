<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use phpDocumentor\Reflection\Types\Null_;

class UpdateNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function($table) {
            $table->string('thumbnail_home', 255)->nullable();
            $table->integer('featured')->default(0);
            $table->integer('featured_home')->default(0);
            $table->softDeletes();
            $table->string('slug', 255)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function($table) {
            $table->dropColumn('thumbnail_home');
            $table->dropColumn('featured');
            $table->dropColumn('featured_home');
            $table->dropColumn('deleted_at');
        });
    }
}
