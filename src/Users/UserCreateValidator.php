<?php namespace B50\Forums\Users;

use B50\Forums\Core\Validation\Validator;

/**
 * Class UserCreateValidator
 *
 * @package B50\Forums\Users
 */
class UserCreateValidator extends Validator
{
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
