<?php namespace LaravelForums\Forums\Topics\Read;

/**
 * Class EloquentRead
 *
 * @package LaravelForums\Forums\Topics\Read
 */
class EloquentTopicRead extends \Eloquent {

	public $table = 'forum_topic_read';
	public $timestamps = false;
	public $fillable = ['topic_id', 'user_id'];

}
