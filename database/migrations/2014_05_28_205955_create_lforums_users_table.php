<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLforumsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums_users', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->integer('posts');
            $table->integer('topics');
            $table->string('signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('lforums_users');
    }
}
