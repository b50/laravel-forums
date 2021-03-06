<?php namespace B50\Forums;

use Illuminate\Database\Seeder;
use B50\Forums\Posts\EloquentPost;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('lforums_posts')->delete();

        EloquentPost::create([
            'id' => 1,
            'created_at' => strtotime('2 weeks ago'),
            'updated_at' => strtotime('2 weeks ago'),
            'topic_id' => 1,
            'author_id' => 2,
            'markdown' => 'hello :)',
            'html' => 'hello :)',
            'developer_response' => false,
        ]);

        EloquentPost::create([
            'id' => 2,
            'topic_id' => 2,
            'author_id' => 1,
            'markdown' => 'lalala',
            'created_at' => strtotime('1 week ago'),
            'updated_at' => strtotime('1 week ago'),
            'html' => 'lalala',
            'developer_response' => false,
        ]);

        EloquentPost::create([
            'id' => 3,
            'topic_id' => 2,
            'author_id' => 2,
            'markdown' => 'Second post T_T',
            'html' => 'Second post T_T',
            'developer_response' => false,
            'created_at' => strtotime('5 days ago'),
            'updated_at' => strtotime('5 days ago'),
        ]);

        EloquentPost::create([
            'id' => 4,
            'topic_id' => 3,
            'author_id' => 2,
            'markdown' => "I have no need for any of the several hundred emojis that my phone now loads whenever I want
			to write \":-)\" to someone. I've always only used the standard emojis, and I really see no reason to start
			 using the others. But now my keyboard is sluggish because it needs to load the rest. Can I please
			 have the option to disable them?",
            'html' => "I have no need for any of the several hundred emojis that my phone now loads whenever I want
			to write \":-)\" to someone. I've always only used the standard emojis, and I really see no reason to start
			 using the others. But now my keyboard is sluggish because it needs to load the rest. Can I please
			 have the option to disable them?",
            'developer_response' => false,
            'created_at' => strtotime('4 days ago'),
            'updated_at' => strtotime('4 days ago'),
        ]);

        EloquentPost::create([
            'id' => 5,
            'topic_id' => 3,
            'author_id' => 1,
            'markdown' => "Hello Community,

Thank you for expressing your feedback. While emoji was a very highly suggested feature we realize that emoji are not for everyone.

You do not have to use these new emojis at all. We understand how they can turn SMS’s with emoji into MMS and cost you more money.

The original emoticons are still available for use if you launch the emoji happen and swipe to the far right panel.

Alternatively, you can go into:
1. SwiftKey settings
2. Layout
3. Chose to have emoji show up by longpress or shortpress – so you don’t even have to bring up the emoji panel.

We look at all feedback and take it into account.",
            'html' => "<p>Hello Community,</p><p>Thank you for expressing your feedback. While emoji was a very highly suggested feature we realize that emoji are not for everyone.</p><p>You do not have to use these new emojis at all. We understand how they can turn SMS’s with emoji into MMS and cost you more money.</p><p>The original emoticons are still available for use if you launch the emoji happen and swipe to the far right panel.</p><p>Alternatively, you can go into:</p><ol><li>SwiftKey settings</li><li>Layout</li><li>Chose to have emoji show up by longpress or shortpress – so you don’t even have to bring up the emoji panel.</li></ol><p>We look at all feedback and take it into account.</p>",
            'developer_response' => true,
            'created_at' => strtotime('3 days ago'),
            'updated_at' => strtotime('3 days ago'),
        ]);

        EloquentPost::create([
            'id' => 6,
            'topic_id' => 3,
            'author_id' => 3,
            'markdown' => 'This sucks omg',
            'html' => 'This sucks omg',
            'developer_response' => false,
            'created_at' => strtotime('2 days ago'),
            'updated_at' => strtotime('2 days ago'),
        ]);

        EloquentPost::create([
            'id' => 7,
            'topic_id' => 4,
            'author_id' => 3,
            'markdown' => 'This is lovely.',
            'html' => '<p>This is lovely.</p>',
            'developer_response' => false,
            'created_at' => strtotime('1 day ago'),
            'updated_at' => strtotime('1 day ago'),
        ]);

        EloquentPost::create([
            'id' => 8,
            'topic_id' => 4,
            'author_id' => 1,
            'markdown' => '> <cite>@bob wrote on 2 seconds ago</cite>
>
> <p>This is lovely.</p>

IKR!! :)',
            'html' => '<blockquote><p><cite><a href="http://site.app:8000/users/bob">Bob</a> wrote on 2 seconds ago</cite></p><p>This is lovely.</p></blockquote><p>IKR!! :)</p>',
            'developer_response' => false,
            'created_at' => time(),
        ]);
    }
}
