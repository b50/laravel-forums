<?php namespace LaravelForums\Users;

use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Present the post
 *
 * @package LaravelForums\Forums\Forums
 */
class UserPresenter extends BasePresenter {

	/**
	 * @param EloquentUser $user
	 */
	public function __construct(EloquentUser $user)
	{
		$this->resource = $user;
	}

}
