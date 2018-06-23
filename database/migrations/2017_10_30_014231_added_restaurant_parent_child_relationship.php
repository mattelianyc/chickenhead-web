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
        $table->integer('parent')->unsigned()->nullable()->after('id');
        $table->foreign('parent')->references('id')->on('restaurants');
        $table->string('location_name')->after('name');
        $table->text('website')->after('longitude');
        $table->text('description')->after('website');
        $table->integer('added_by')->after('description')->unsigned()->nullable();
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
        $table->dropColumn('parent');
        $table->dropColumn('location_name');
        $table->dropColumn('website');
        $table->dropColumn('description');
        $table->dropColumn('added_by');
      });
    }
}
