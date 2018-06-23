<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedRestaurantParentChildRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('restaurants', function( Blueprint $table ){
        $table->text('website')->after('longitude')->nullable();
        $table->text('description')->after('website')->nullable();
        $table->integer('added_by')->after('description')->unsigned();
        $table->foreign('added_by')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('restaurants', function( Blueprint $table ){
        $table->dropColumn('website');
        $table->dropColumn('description');
        $table->dropColumn('added_by');
      });
    }
}
