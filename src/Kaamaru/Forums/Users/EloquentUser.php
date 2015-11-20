<?php namespace Kaamaru\Forums\Users;

use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * The user
 *
 * @package Kaamaru\Forums\Users
 */
class EloquentUser extends \Eloquent implements HasPresenter
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lforums_users';
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
        return $this->hasMany('Kaamaru\Forums\Users\Group\EloquentUserGroup', 'user_id');
    }

    /**
     * When the user was last online if they are online
     *
     * @return int timestamp
     */
    public function getOnlineAttribute()
    {
        return \Cache::get('users_online:user_' . $this->id);
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenterClass()
    {
        return 'Kaamaru\Forums\Users\UserPresenter';
    }
}