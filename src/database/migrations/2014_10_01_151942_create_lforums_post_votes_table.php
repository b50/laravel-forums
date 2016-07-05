<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLForumsPostVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums_post_votes', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('post_id');
            $table->boolean('positive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('lforums_post_votes');
    }
}
