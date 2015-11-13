<?php
use LaravelForums\Forums\Forums\EloquentForum;

/**
 * Class ForumsTableSeeder
 */
class ForumsTableSeeder extends Seeder{

	protected $ids = [
		'news' => 1,
		'general' => 5,
		'games' => 8,
		'suggestions' => 9,
		'test' => 10,
	];

	public function run()
	{
		DB::table('forums')->delete();

		EloquentForum::create([
			'id' => $this->ids['general'],
			'path' => $this->ids['general'],
			'slug' => 'general',
			'name' => _('General'),
			'description' => _('Lots of news'),
			'posts' => 3,
			'topics_count' => 2,
			'rank' => 1,
			'last_topic' => 2
		]);

		EloquentForum::create([
			'id' => $this->ids['news'],
			'slug' => 'news',
			'name' => _('News & announcements'),
			'description' => _('Lots of news'),
			'path' => $this->ids['general'].'/'.$this->ids['news'],
			'posts' => 3,
			'topics_count' => 2,
			'rank' => 2,
			'last_topic' => 2,
		]);

		EloquentForum::create([
			'id' => $this->ids['games'],
			'path' =>  $this->ids['test'].'/'.$this->ids['games'],
			'slug' => 'games',
			'name' => _('Games'),
			'description' => _('COUNTER STRIKE'),
			'rank' => 4,
			'posts' => 0,
			'topics_count' => 0,
		]);

		EloquentForum::create([
			'id' => $this->ids['suggestions'],
			'path' =>  $this->ids['test'].'/'.$this->ids['suggestions'],
			'slug' => 'suggestions',
			'name' => _('Suggestions'),
			'description' => _('suggestions...'),
			'rank' => 4,
			'posts' => 0,
			'topics_count' => 0,
			'type' => 'suggestions'
		]);

		EloquentForum::create([
			'id' => $this->ids['test'],
			'path' =>  $this->ids['test'],
			'slug' => 'test',
			'name' => _('Test'),
			'description' => _('test...'),
			'rank' => 55,
			'posts' => 0,
			'topics_count' => 0,
		]);

	}

}
