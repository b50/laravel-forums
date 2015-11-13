<?php namespace LaravelForums\Core\Validation;

/**
 * Extend validator to add more rules
 *
 * @package App\Classes
 */
class ValidationRules extends \Illuminate\Validation\Validator {

	/**
	 * Validate does not equal
	 *
	 * @param       $attribute
	 * @param       $value
	 * @param array $parameters
	 * @return bool
	 */
	protected function validateNot($attribute, $value, $parameters)
	{
		return $value != $parameters[0];
	}

	/**
	 * Validate exists in ether column
	 *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @return bool
	 */
	protected function validateExistsEither($attribute, $value, $parameters)
	{
		$table = $parameters[0];
		$columns = [$parameters[1], $parameters[2]];

		return (bool) \DB::table($table)->where($columns[0], $value)->orWhere($columns[1], $value)->count();
	}
}
