<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Service base class. All services should extend this class.
 */
abstract class SampleApp_Service
{

	/**
	 * Store build instances
	 */
	private static $_instances = array();

	/**
	 * Common function to enqueue jobs.
	 * For a given <Action> into a given <Service>, your should define
	 * a class named Task_App_<Service>_<Action> which inherits from
	 * Task_App_Job.
	 *
	 * @param {string} $action The name of the action
	 * @param {string} $params An array of parameters
	 */
	protected function enqueue ( $action, $params )
	{
		// Get the class name
		$classname = preg_replace('/^service_/', '', strtolower(get_class($this)));

		// Build the task name
		$taskname = $classname.':'.strtolower($action);

		// Push a job into the queue
		Service::factory('Queue')->push($taskname, $params);
	}

	/**
	 * Create a new service instance.
	 *
	 *     $service = Service::factory($name);
	 *
	 * @param {string} $name
	 * @return {Service}
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

} // End SampleApp_Service
