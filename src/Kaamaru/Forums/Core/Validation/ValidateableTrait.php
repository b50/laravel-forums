<?php namespace Kaamaru\Forums\Core\Validation;

/**
 * Allow the class to validate itself
 *
 * Class ValidatableTrait
 * @package App\Traits
 */
trait ValidatableTrait
{
    /**
     * @var \App\Validation\Validator
     */
    protected $validator;

    /**
     * Validate data
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data)
    {
        $this->validator->validate($data);

        return $this->validator->errors;
    }

    /**
     * Return validation errors
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function validationErrors()
    {
        return $this->validator->errors;
    }
}
