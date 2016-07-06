<?php namespace Kaamaru\Forums\Read;

/**
 * Class EloquentRead
 *
 * @package Kaamaru\Forums\Forums
 */
class EloquentForumRead extends \Eloquent
{
    public $table = 'lforums_read';
    public $timestamps = false;
    public $fillable = ['forum_id', 'user_id'];
}
