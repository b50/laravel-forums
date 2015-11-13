<?php namespace LaravelForums\Forums\Topics;

use LaravelForums\Forums\Posts\PostValidator;

/**
 * Validate user
 *
 * @package App\Validation\Users
 */
class TopicValidator extends PostValidator {

	/**
	 * @return array
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			'title' => 'required|min:3',
			'path' => 'required|exists:forums,path'
		]);
	}

}
