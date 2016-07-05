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
            $table->string('username', 30);
            $table->unique('username');
            $table->string('email', 254);
            $table->unique('email');
            $table->string('slug', 30);
            $table->string('password');
            $table->integer('posts');
            $table->integer('topics');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->string('remember_token')->nullable();
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
