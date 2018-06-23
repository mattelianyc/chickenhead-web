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
            $table->text('favorite_restaurant')->after('avatar')->nullable();
            $table->text('favorite_dish')->after('favorite_restaurant')->nullable();
            $table->boolean('profile_visibility')->default('1')->after('favorite_dish');
            $table->string('city')->after('profile_visibility')->nullable();
            $table->string('state')->after('city')->nullable();
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
