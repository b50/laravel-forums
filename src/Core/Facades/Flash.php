<?php namespace LaravelForums\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Flash facade
 *
 * @package LaravelForums\Core\Facades
 */
class Flash extends Facade {

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
