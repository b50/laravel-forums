<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateForumTopicsTable
 */
class CreateLforumsTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums_topics', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->string('title', 100);
            $table->string('slug', 100);
            $table->integer('user_id');
            $table->timestamp('deleted_at')->nullable();
            $table->string('path', 100)->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->integer('posts_count')->default(0);
            $table->integer('views')->default(0);
            $table->integer('last_post')->nullable();
            $table->integer('last_post_user')->nullable();
            $table->boolean('sticky')->default(0);
            $table->boolean('locked')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->integer('followers')->default(0);
            $table->string('tag')->nullable();

            $table->index(['sticky', 'updated_at']);
            $table->index(['sticky', 'title']);
            $table->index(['sticky', 'views']);
            $table->index(['sticky', 'posts_count']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('lforums_topics');
    }
}
