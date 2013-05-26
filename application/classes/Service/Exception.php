<?php defined('SYSPATH') or die('No direct script access.');

abstract class Service_Exception extends Kohana_Exception
{

	/**
	 * Error data
	 */
	private $_data = array();

	/**
	 * Build a new service exception
	 * You could pass all desired arguments
	 *
	 * @param {string} $name
	 * @return {Service_Exception}
	 */
	public static function factory ( $name )
	{
		// Add the service exception prefix
		$class = 'Service_Exception_'.$name;

		// Get arguments
		$args = func_get_args();
		array_shift($args);

		// Get reflection class from the classname
		$reflection = new ReflectionClass($class);

		// Return the exception object from args
		return $reflection->newInstanceArgs($args);
	}

	/**
	 * Get or set error data
	 *
	 * @param {array} $data
	 * @return {array|Service_Exception}
	 */
	public function data ( $data = NULL )
	{
		if (is_null($data))
			return $this->_data;

		$this->_data = $data;
		return $this;
	}

}
