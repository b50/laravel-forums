<?php namespace LaravelForums\Users;

use LaravelForums\Core\Validation\Validator;

/**
 * Class UserCreateValidator
 *
 * @package LaravelForums\Users
 */
class UserCreateValidator extends Validator {

	/**
	 * {{ @inheritDocs }}
	 */
	public function rules()
	{
		return [
			'username' => 'required|unique:users,id',
			'password' => 'required|min:6|confirmed',
			'email' => 'required|email|unique:users',
			'terms' => 'accepted'
		];
	}

}
