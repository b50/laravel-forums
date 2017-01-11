<?php namespace B50\Forums\Users\Group;

/**
 * Class EloquentGroup
 *
 * @package B50\Forums\Core\Auth
 */
class EloquentUserGroup extends \Eloquent
{
    public $timestamps = false;
    public $fillable = ['user_id', 'group'];
    protected $table = 'lforums_user_group';
}
