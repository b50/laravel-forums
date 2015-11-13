<?php namespace LaravelForums\Forums\Posts\Vote;

/**
 * Class EloquentVote
 *
 * @package LaravelForums\Forums\Posts\Votes
 */
class EloquentPostVote extends \Eloquent {

	public $timestamps = false;
	public $table = 'forum_post_votes';
	public $fillable = ['user_id', 'post_id', 'positive'];

}
