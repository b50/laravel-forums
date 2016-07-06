<?php namespace Kaamaru\Forums\Topics\Follow;

/**
 * Class EloquentFollowing
 *
 * @package Kaamaru\Forums\Topics\Following
 */
class EloquentFollow extends \Eloquent
{
    public $table = 'forum_topic_follow';
    public $timestamps = false;
}
