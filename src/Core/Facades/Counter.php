<?php namespace B50\Forums\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Counter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'counter';
    }
}
