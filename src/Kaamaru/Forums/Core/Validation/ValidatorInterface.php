<?php namespace Kaamaru\Forums\Core\Validation;

/**
 * Class Validator
 *
 * @package App\Validation
 */
interface ValidatorInterface
{
    /**
     * Validates the input.
     *
     * @param array $data
     * @return bool
     */
    public function validate($data = []);

    /**
     * Get validation errors
     *
     * @return mixed
     */
    public function errors();

    /**
     * Get rules
     */
    public function rules();

    /**
     * Get error messages
     *
     * @return mixed
     */
    public function messages();
}
