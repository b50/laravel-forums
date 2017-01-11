<?php namespace Kaamaru\Forums\Core\Facades;

use Illuminate\Support\Facades\Facade;

class FineDiff extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'finediff';
    }
}
