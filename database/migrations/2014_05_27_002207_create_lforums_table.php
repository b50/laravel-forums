<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLforumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('path', 100)->nullable();
            $table->string('description');
            $table->tinyInteger('rank', false, true);
            $table->integer('post_count');
            $table->integer('topic_count');
            $table->integer('last_topic_id')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('lforums');
    }
}
