<?php namespace Kaamaru\Forums\Users;

use App\User;
use Kaamaru\Forums\Users\Group\EloquentUserGroup;
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
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Groups relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(EloquentUserGroup::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
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
        return UserPresenter::class;
    }
}
