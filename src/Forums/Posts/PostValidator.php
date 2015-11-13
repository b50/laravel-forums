<?php namespace LaravelForums\Forums\Posts;

use LaravelForums\Core\Validation\Validator;

/**
 * Validate user
 *
 * @package App\Validation\Users
 */
class PostValidator extends Validator {

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			'content' => 'required|min:3'
		];
	}

}
