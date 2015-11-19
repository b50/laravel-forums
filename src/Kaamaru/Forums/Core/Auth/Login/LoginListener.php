<?php namespace Kaamaru\Forums\Core\Auth\Login;

/**
 * Interface AuthListener
 *
 * @package Kaamaru\Forums\Core\Auth
 */
interface LoginListener
{
    /**
     * User successfully logged in
     *
     * @return mixed
     */
    public function loggedIn();

    /**
     * Invalid login credentials
     *
     * @param $errors
     * @return mixed
     */
    public function invalidLogin($errors);
}
