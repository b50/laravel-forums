<?php namespace B50\Forums\Posts\Report;

/**
 * Class EloquentPostReport
 *
 * @package B50\Forums\Posts\Votes
 */
class EloquentPostReport extends \Eloquent
{
    public $timestamps = false;
    public $table = 'forum_post_reports';
    public $fillable = ['user_id', 'post_id'];
}
