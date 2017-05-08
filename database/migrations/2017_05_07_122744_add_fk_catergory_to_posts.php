<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkCatergoryToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('posts', function ($table) {
//            $table->foreign('category_id')
//                ->references('id')
//                ->on('categories')
//                ->onDelete('restrict')
//                ->onUpdate('restrict');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::disableForeignKeyConstraints();
//
//        Schema::table('posts', function ($table) {
//            $table->dropForeign('category_id');
//        });
//
//        Schema::enableForeignKeyConstraints();

    }
}
