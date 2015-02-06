<?php namespace Maka\Less4laravel;

use Illuminate\Support\Facades\Facade;

class LessFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'less'; }

}