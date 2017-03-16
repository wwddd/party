<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('gender');
            $table->integer('age');
            $table->string('country');
            $table->string('city');
            $table->string('contact');
            $table->string('email')->unique();
            $table->string('password');
            $table->smallInteger('type')->nullable();
            $table->integer('payment_time')->nullable();
            $table->integer('events_count')->nullable();
            $table->integer('followers_count')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('ip')->nullable()->unsigned();
            $table->smallInteger('blocked')->nullable();
            $table->smallInteger('verified')->nullable();
            $table->smallInteger('noticed')->nullable();
            $table->rememberToken();
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
