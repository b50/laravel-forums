<?php namespace LaravelForums\Core\Auth;

/**
 * Filter topic order
 *
 * @package App\Filters\Forums
 */
class AuthFilter {

	public function filter()
	{
		if (\Auth::guest())
		{
			return \Redirect::guest('login');
		}
	}

}
