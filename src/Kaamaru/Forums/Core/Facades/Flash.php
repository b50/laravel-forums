<?php namespace Kaamaru\Forums\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Flash facade
 *
 * @package Kaamaru\Forums\Core\Facades
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
