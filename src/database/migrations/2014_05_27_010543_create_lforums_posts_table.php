<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLforumsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums_posts', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->integer('topic_id');
            $table->integer('user_id');
            $table->text('markdown');
            $table->text('html');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->integer('votes')->default(0);
            $table->boolean('developer_response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('forum_posts');
    }
}
