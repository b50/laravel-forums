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
            $table->integer('author_id');
            $table->timestamp('deleted_at')->nullable();
            $table->integer('forum_id')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->integer('post_count')->default(0);
            $table->integer('views')->default(0);
            $table->integer('last_post_id')->nullable();
            $table->integer('last_post_user_id')->nullable();
            $table->boolean('sticky')->default(0);
            $table->boolean('locked')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->integer('followers')->default(0);
            $table->string('tag')->nullable();

            $table->index(['sticky', 'updated_at']);
            $table->index(['sticky', 'title']);
            $table->index(['sticky', 'views']);
            $table->index(['sticky', 'post_count']);
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
