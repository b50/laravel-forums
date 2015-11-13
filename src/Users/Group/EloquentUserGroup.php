<?php namespace LaravelForums\Users\Group;

/**
 * Class EloquentGroup
 *
 * @package LaravelForums\Core\Auth
 */
class EloquentUserGroup extends \Eloquent {

	public $timestamps = false;
	public $fillable = ['user_id', 'group'];
	protected $table = 'user_group';

}
