<?php namespace LaravelForums\Forums\Forums\Read;

/**
 * Class EloquentRead
 *
 * @package LaravelForums\Forums\Forums
 */
class EloquentForumRead extends \Eloquent {

	public $table = 'forum_read';
	public $timestamps = false;
	public $fillable = ['forum_id', 'user_id'];

}
