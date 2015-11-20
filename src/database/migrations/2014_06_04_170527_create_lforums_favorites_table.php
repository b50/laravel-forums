<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLforumsFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('lforums_favorites', function ($table) {
            /** @var Blueprint $table */
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('topic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('forum_favorites');
    }
}
