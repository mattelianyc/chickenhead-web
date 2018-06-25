<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedUserProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('favorite_restaurant')->nullable();
            $table->text('favorite_dish')->nullable();
            $table->boolean('profile_visibility')->default('1');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('favorite_restaurant');
            $table->dropColumn('favorite_dish');
            $table->dropColumn('profile_visibility');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
}
