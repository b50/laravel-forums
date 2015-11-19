<?php namespace Kaamaru\Forums\Core\Auth\Login;

use Kaamaru\Forums\Core\Auth\Auth;

/**
 * Move a post
 *
 * @package App\Forums\TopicMoveService
 */
class LoginRequest
{
    /**
     * @param LoginValidator $validator
     * @param Auth $auth
     * @internal param Auth $creator
     */
    public function __construct(LoginValidator $validator, Auth $auth)
    {
        $this->validator = $validator;
        $this->auth = $auth;
    }

    /**
     * Move topic
     *
     * @param LoginListener $listener
     * @param array $input
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginListener $listener, $input)
    {
        // Validate
        if (!$this->validator->validate($input)) {
            return $listener->invalidLogin($this->validator->errors());
        };

        // Login
        if ($this->auth->login($input)) {
            return $listener->loggedIn();
        }

        return $listener->invalidLogin(['password' => _('Wrong password')]);
    }
}
