<?php namespace B50\Forums\Topics\Follow;

/**
 * Class EloquentFollowing
 *
 * @package B50\Forums\Topics\Following
 */
class EloquentFollow extends \Eloquent
{
    public $table = 'forum_topic_follow';
    public $timestamps = false;
}
