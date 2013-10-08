<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Inherits from this class if you would run task as a job into the queue system
 */
abstract class SampleApp_Task_Job extends Task_App
{

	/**
	 * Sets options for this task
	 *
	 * $param  array  the array of options to set
	 * @return this
	 */
	public function set_options(array $options)
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

} // End of SampleApp_Task_Job

