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
            $table->string('city');
            $table->string('place');
            $table->string('image');
            $table->string('description');
            $table->string('contact');
            $table->integer('start');
            $table->string('tags');
            $table->smallInteger('status');
            $table->smallInteger('verify');
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
