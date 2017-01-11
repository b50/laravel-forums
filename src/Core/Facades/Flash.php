<?php namespace B50\Forums\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Flash facade
 *
 * @package B50\Forums\Core\Facades
 */
class Flash extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }
}
