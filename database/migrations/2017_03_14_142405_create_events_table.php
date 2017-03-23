<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table){
            $table->increments('id');
            $table->smallInteger('user_id');
            $table->string('title');
            $table->string('country', 50);
            $table->string('city', 50);
            $table->string('place');
            $table->string('image')->nullable();
            $table->string('description', 1000);
            $table->string('contact', 100);
            $table->integer('start');
            $table->string('tags')->nullable();
            $table->string('offer')->nullable();
            $table->string('peoples_count')->nullable();
            $table->integer('rating')->default(0); // change without check
            $table->smallInteger('status');
            $table->smallInteger('verify');
            $table->string('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
