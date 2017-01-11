<?php namespace B50\Forums\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Class BaseController
 *
 * @package App\Controllers
 */
class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * @param $route
     */
    public function redirectToRoute($route)
    {
        \Redirect::route($route);
    }
}
