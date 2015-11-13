<?php namespace LaravelForums\Core\Auth;

/**
 * Class Auth
 *
 * @package LaravelForums\Core\Auth
 */
class Auth {

	/**
	 * Log the user into their account
	 *
	 * @return bool
	 */
	public function login($input)
	{
		$remember = isset($input['remember']);

		// Try login with username
		if (\Auth::attempt(['username' => $input['usermail'], 'password' => $input['password']], $remember))
		{
			return true;
		}

		// Try login with email
		if (\Auth::attempt(['email' => $input['usermail'], 'password' => $input['password']], $remember))
		{
			return true;
		}

		// Failed to login
		return false;
	}

}
