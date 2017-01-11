<?php namespace Kaamaru\Forums\Topics\Read;

/**
 * Class EloquentRead
 *
 * @package Kaamaru\Forums\Topics\Read
 */
class EloquentTopicRead extends \Eloquent
{
    public $table = 'lforums_topic_read';
    public $timestamps = false;
    public $fillable = ['topic_id', 'user_id'];
}
