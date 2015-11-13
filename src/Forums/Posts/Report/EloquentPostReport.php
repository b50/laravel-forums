<?php namespace LaravelForums\Forums\Posts\Report;

/**
 * Class EloquentPostReport
 *
 * @package LaravelForums\Forums\Posts\Votes
 */
class EloquentPostReport extends \Eloquent {

	public $timestamps = false;
	public $table = 'forum_post_reports';
	public $fillable = ['user_id', 'post_id'];

}
