<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->date('dob');
            $table->string('gender');
            $table->string('city');
            $table->string('country');
            $table->string('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('image_public_id')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('cover_image_public_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('interest')->nullable();
            $table->string('interest_age_range')->nullable();
            $table->string('language')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
