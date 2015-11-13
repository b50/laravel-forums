<?php namespace LaravelForums\Forums\Topics\Follow;

/**
 * Class EloquentFollowing
 *
 * @package LaravelForums\Forums\Topics\Following
 */
class EloquentFollow extends \Eloquent {

	public $table = 'forum_topic_follow';
	public $timestamps = false;

}
