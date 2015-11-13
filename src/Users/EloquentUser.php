<?php namespace LaravelForums\Users;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use McCool\LaravelAutoPresenter\PresenterInterface;

/**
 * The user
 *
 * @package LaravelForums\Users
 */
class EloquentUser extends \Eloquent implements UserInterface, RemindableInterface, PresenterInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Disable timestamps
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Groups relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function groups()
	{
		return $this->hasMany('LaravelForums\Users\Group\EloquentUserGroup', 'user_id');
	}

	/**
	 * When the user was last online if they are online
	 *
	 * @return int timestamp
	 */
	public function getOnlineAttribute()
	{
		return \Cache::get('users_online:user_'.$this->id);
	}

	/**
	 * Get the presenter class.
	 *
	 * @return string The class path to the presenter.
	 */
	public function getPresenter()
	{
		return 'LaravelForums\Users\UserPresenter';
	}

}
