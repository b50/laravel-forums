<?php namespace Kaamaru\Forums\Users\Group;

/**
 * Class EloquentGroup
 *
 * @package Kaamaru\Forums\Core\Auth
 */
class EloquentUserGroup extends \Eloquent
{
    public $timestamps = false;
    public $fillable = ['user_id', 'group'];
    protected $table = 'user_group';
}
