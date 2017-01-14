<?php namespace B50\Forums;

use Illuminate\Database\Seeder;
use B50\Forums\Forums\EloquentForum;

/**
 * Class ForumsTableSeeder
 */
class ForumsTableSeeder extends Seeder
{
    public $ids = [
        'news' => 1,
        'general' => 5,
        'games' => 8,
        'suggestions' => 9,
        'test' => 10,
        'subnews' => 2
    ];

    public function run()
    {
        \DB::table('lforums')->delete();

        EloquentForum::create([
            'id' => $this->ids['general'],
            'slug' => 'general',
            'name' => _('General'),
            'description' => _('General stuff...'),
            'post_count' => 3,
            'topic_count' => 2,
            'rank' => 1,
            'last_topic_id' => 2
        ]);

        EloquentForum::create([
            'id' => $this->ids['news'],
            'slug' => 'news',
            'name' => _('News & announcements'),
            'description' => _('Lots of news'),
            'path' => $this->ids['general'],
            'post_count' => 3,
            'topic_count' => 2,
            'rank' => 2,
            'last_topic_id' => 2,
        ]);

        EloquentForum::create([
            'id' => $this->ids['subnews'],
            'slug' => 'news',
            'name' => _('Subnews'),
            'description' => _('More news'),
            'path' => $this->ids['general'] . '/' . $this->ids['news'],
            'post_count' => 0,
            'topic_count' => 0,
            'rank' => 2,
        ]);

        EloquentForum::create([
            'id' => $this->ids['games'],
            'path' => $this->ids['test'],
            'slug' => 'games',
            'name' => _('Games'),
            'description' => _('COUNTER STRIKE'),
            'rank' => 4,
            'post_count' => 0,
            'topic_count' => 0,
        ]);

        EloquentForum::create([
            'id' => $this->ids['suggestions'],
            'path' => $this->ids['test'],
            'slug' => 'suggestions',
            'name' => _('Suggestions'),
            'description' => _('suggestions...'),
            'rank' => 4,
            'post_count' => 0,
            'topic_count' => 0,
            'type' => 'suggestions'
        ]);

        EloquentForum::create([
            'id' => $this->ids['test'],
            'slug' => 'test',
            'name' => _('Test'),
            'description' => _('test...'),
            'rank' => 55,
            'post_count' => 0,
            'topic_count' => 0,
        ]);

    }
}
