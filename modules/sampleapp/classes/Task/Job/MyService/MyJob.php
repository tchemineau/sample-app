<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is a sample task that could be run as a job by the queue service
 *
 * It can accept the following options:
 *  - p1: the first parameter. It is required.
 *  - p2: the second parameter.
 */
class Task_Job_MyService_MyJob extends Task_Job
{

	/**
	 * Available parameters
	 * @var
	 */
	protected $_options = array(
		'p1' => NULL,
		'p2' => NULL,
	);

	/**
	 * Sample-App will execute this function.
	 */
	protected function _execute ( array $params )
	{
		// Get the first parameter
		$p1 = $params['p1'];

		// Get the second parameter
		$p2 = $params['p2'];

		// Process
		$this->process($p1, $p2);
	}

	/**
	 * Validate parameters
	 */
	public function build_validation ( Validation $validation )
	{
		return parent::build_validation($validation)
			->rule('p1', 'not_empty');
	}

	/**
	 * Process to the job
	 */
	public function process ( $p1, $p2 )
	{
		echo "Execute MyService/MyJob with the following parameters:\n"
			."p1: $p1\n"
			."p2: $p2\n";
	}

} // End of Task_Job_MyService_MyJob

