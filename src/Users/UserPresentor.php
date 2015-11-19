<?php namespace Kaamaru\Forums\Users;

use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the post
 *
 * @package Kaamaru\Forums\Forums\Forums
 */
class UserPresenter extends BasePresenter
{
    /**
     * @param EloquentUser $user
     */
    public function __construct(EloquentUser $user)
    {
        $this->resource = $user;
    }
}
