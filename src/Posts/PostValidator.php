<?php namespace B50\Forums\Posts;

use B50\Forums\Core\Validation\Validator;

/**
 * Validate user
 *
 * @package App\Validation\Users
 */
class PostValidator extends Validator
{
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
