<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('restaurants', function( Blueprint $table ){
        $table->increments('id');
        $table->string('name')->nullable();
        $table->text('address');
        $table->string('city');
        $table->string('state');
        $table->string('zip');
        $table->decimal('latitude', 11, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('description')->nullable();
        $table->string('website')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
