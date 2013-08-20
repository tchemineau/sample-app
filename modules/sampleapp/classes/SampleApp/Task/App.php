<?php defined('SYSPATH') or die('No direct script access.');

abstract class SampleApp_Task_App extends Minion_Task
{

	/**
	 * Execute a Shell command
	 *
	 * @param $command
	 * @return {array}
	 */
	protected static function _execute_shell ( $command )
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

} // End SampleApp_Task_App

