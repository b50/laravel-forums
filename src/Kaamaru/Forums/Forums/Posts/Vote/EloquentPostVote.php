<?php namespace Kaamaru\Forums\Forums\Posts\Vote;

/**
 * Class EloquentVote
 *
 * @package Kaamaru\Forums\Forums\Posts\Votes
 */
class EloquentPostVote extends \Eloquent
{
    public $timestamps = false;
    public $table = 'forum_post_votes';
    public $fillable = ['user_id', 'post_id', 'positive'];
}
