<?php defined('SYSPATH') or die('No direct script access.');

abstract class SampleApp_Task_App extends Minion_Task
{

	/**
	 * Execute a Shell command
	 *
	 * @param $command
	 * @return {array}
	 */
	public static function execute_shell ( $command )
	{
		$script_output = null;
		$script_status = 0;

		exec($command.' 2>&1', $script_output, $script_status);

		return array(
			'error' => $script_status != 0,
			'output' => $script_output,
			'status' => $script_status
		);
	}

	/**
	 * Sets options for this task
	 *
	 * $param  array  the array of options to set
	 * @return this
	 */
	public function set_options ( array $options )
	{
		// Call parent method
		parent::set_options($options);

		// Now parse all options and decode values
		foreach ($this->_options as $k => $v)
		{
			// Try to convert into array
			$value = $v != '' ? explode(',', $v) : NULL;

			// Do not store array if only one value
			if (!is_null($value) and sizeof($value) == 1)
				$value = $value[0];

			// Reassign the value
			$this->_options[$k] = $value;
		}

		return $this;
	}

} // End SampleApp_Task_App

