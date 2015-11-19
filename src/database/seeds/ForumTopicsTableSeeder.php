<?php
use Kaamaru\Forums\Forums\Topics\EloquentTopic;

/**
 * Class ForumTopicsTableSeeder
 */
class ForumTopicsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('forum_topics')->delete();

        EloquentTopic::create([
            'id' => 1,
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'posts_count' => 1,
            'path' => '5/1/3',
            'user_id' => 2,
            'last_post_user' => 2,
            'last_post' => 1,
            'views' => 0,
            'sticky' => false,
            'updated_at' => strtotime('1 week ago'),
            'created_at' => strtotime('1 week ago'),
        ]);

        EloquentTopic::create([
            'id' => 2,
            'title' => 'Hello!',
            'slug' => 'hello',
            'posts_count' => 2,
            'views' => 0,
            'path' => '5/1/3',
            'user_id' => 1,
            'last_post_user' => 2,
            'last_post' => 2,
            'updated_at' => strtotime('yesterday'),
            'created_at' => strtotime('2 days ago'),
            'sticky' => false,
        ]);

        EloquentTopic::create([
            'id' => 3,
            'title' => 'Suggestion',
            'slug' => 'suggestion',
            'posts_count' => 1,
            'path' => '10/9',
            'user_id' => 2,
            'last_post_user' => 2,
            'last_post' => 1,
            'views' => 0,
            'sticky' => false,
            'updated_at' => strtotime('3 week ago'),
            'created_at' => strtotime('2 week ago'),
            'tag' => 'Closed',
        ]);

        EloquentTopic::create([
            'id' => 4,
            'title' => 'test',
            'slug' => 'test-test-test',
            'posts_count' => 1,
            'user_id' => 2,
            'last_post_user' => 2,
            'last_post' => 1,
            'views' => 0,
            'sticky' => false,
            'updated_at' => strtotime('3 week ago'),
            'created_at' => strtotime('2 week ago'),
            'wiki_id' => 1,
        ]);
    }
}
