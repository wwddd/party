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
            $table->integer('age');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact');
            $table->smallInteger('type');
            $table->integer('payment_time');
            $table->integer('events_count');
            $table->integer('followers_count');
            $table->integer('rating');
            $table->integer('ip')->unsigned();
            $table->smallInteger('blocked');
            $table->smallInteger('verified');
            $table->smallInteger('noticed');
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
