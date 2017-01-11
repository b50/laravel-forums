<?php namespace B50\Forums\Users;

use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the post
 *
 * @package B50\Forums\Forums
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

    /**
     * Return the user's avatar
     * @param string $size
     * @return string
     */
    public function avatar($size = "small")
    {
        $slug = $this->resource->slug;
        return "images/avatars/$slug/$slug-$size.jpg";
    }
}
