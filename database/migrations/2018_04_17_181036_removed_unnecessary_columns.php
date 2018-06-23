<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovedUnnecessaryColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function( Blueprint $table ){
          $table->dropColumn('name');
          $table->dropColumn('website');
          $table->dropColumn('description');
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
        $table->string('name')->after('id');
        $table->text('website')->after('longitude');
        $table->text('description')->after('website');
      });
    }
}
