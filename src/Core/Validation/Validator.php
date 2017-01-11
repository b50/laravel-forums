<?php namespace Kaamaru\Forums\Core\Validation;

use Illuminate\Validation\Factory;

/**
 * Class Validator
 *
 * @package App\Validation
 */
abstract class Validator implements ValidatorInterface
{
    /**
     * @var Factory
     */
    protected $validator;
    /**
     * @var $errors
     */
    protected $errors;

    /**
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($data = [])
    {
        $validator = $this->validator->make($data, $this->rules(), $this->messages());
        $this->errors = $validator->errors();

        return $validator->passes();
    }

    /**
     * {@inheritDoc}
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * {@inheritDoc}
     */
    public function messages()
    {
        return [];
    }
}
