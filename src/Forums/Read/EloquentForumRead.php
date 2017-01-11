<?php namespace B50\Forums\Read;

/**
 * Class EloquentRead
 *
 * @package B50\Forums\Forums
 */
class EloquentForumRead extends \Eloquent
{
    public $table = 'lforums_read';
    public $timestamps = false;
    public $fillable = ['forum_id', 'user_id'];
}
