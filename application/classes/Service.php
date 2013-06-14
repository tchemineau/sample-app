<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Service base class. All services should extend this class.
 */
abstract class Service
{

	/**
	 * Store build instances
	 */
	private static $_instances = array();

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
		if (!isset(self::$_instances[$name]))
		{
			$class = 'Service_'.$name;
			self::$_instances[$name] = new $class;
		}

		return self::$_instances[$name];
	}

} // End Service
