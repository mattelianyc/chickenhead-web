<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedDeleteFlagToRestaurant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function( Blueprint $table ){
          $table->integer('deleted')->default(0)->after('added_by');
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
        $table->dropColumn('deleted');
      });
    }
}
