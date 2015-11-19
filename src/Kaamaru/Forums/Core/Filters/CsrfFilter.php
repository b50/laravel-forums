<?php namespace Kaamaru\Forums\Core\Filters;

use Illuminate\Session\TokenMismatchException;

/**
 * Filter topic order
 *
 * @package App\Filters\Forums
 */
class CsrfFilter
{
    public function filter()
    {
        if (\Session::token() != \Input::get('_token')) {
            throw new TokenMismatchException;
        }
    }
}
