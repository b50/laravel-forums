<?php namespace LaravelForums\Core\Auth\Login;

use LaravelForums\Core\Validation\Validator;

/**
 * Validate user
 *
 * @package App\Validation\Users
 */
class LoginValidator extends Validator {

	/**
	 * @inheritDoc();
	 */
	public function rules()
	{
		return [
			'usermail' => 'required|existsEither:users,username,email',
			'password' => 'required'
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function messages()
	{
		return [
			'exists_either' => "Can't find this username or email.",
			'usermail.required' => 'Please enter a username or email.',
			'password.required' => 'You forgot the password lol'
		];
	}

}
