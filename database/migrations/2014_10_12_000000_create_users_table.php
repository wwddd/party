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
            // $table->string('provider');
            // $table->string('provider_id')->unique();
            $table->string('name', 100);
            $table->string('gender', 15);
            $table->smallInteger('age');
            $table->string('country', 50);
            $table->string('city', 50);
            $table->string('contact', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->smallInteger('type')->nullable();
            $table->integer('payment_time')->nullable();
            $table->integer('events_count')->nullable();
            $table->integer('followers_count')->nullable();
            $table->float('user_rating')->default(0); // here changes without check
            $table->string('ip', 50)->nullable();
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
