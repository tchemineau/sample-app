<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Service base class. All services should extend this class.
 */
abstract class Service
{

	/**
	 * Create a new service instance.
	 *
	 *     $service = Service::factory($name);
	 *
	 * @param {string} $name
	 * @return {Model}
	 */
	public static function factory ( $name )
	{
		// Add the service prefix
		$class = 'Service_'.$name;

		return new $class;
	}

} // End Service
