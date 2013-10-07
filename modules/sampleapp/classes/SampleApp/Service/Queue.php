<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Queue service class
 * Most functions are intended to be use through command line
 */
class SampleApp_Service_Queue extends Service
{

	/**
	 * Execute a job
	 *
	 * @param {string} $id
	 */
	public function execute ( $id )
	{
		// Create the object
		$job = Model::factory('App_Queue');

		// Load it
		$job->load($id);

		// Raise an exception if job could not be loaded
		if (!$job->loaded())
			throw Service_Exception::factory('NotFound', 'Job not found')->data(array('id' => $id));

		// Check task
		if (is_null($job->task))
		{
			$job->set_data(array('status' => Model_App_Queue::ERROR))->save();
			return FALSE;
		}

		// Update the job
		$job->set_data(array('status' => Model_App_Queue::EXEC))->save();

		// For this process
		$pid = pcntl_fork();

		// An error occurs
		if ($pid < 0)
		{
			$job->set_data(array('status' => Model_App_Queue::ERROR))->save();
			return FALSE;
		}

		// The parent process
		else if ($pid > 0)
		{
			$status = null;
			$error = pcntl_waitpid($pid, $status);

			// Update the job status
			if (pcntl_wifexited($status) && pcntl_wexitstatus($status) == 0)
				$job->set_data(array('status' => Model_App_Queue::DONE))->save();
			else
				$job->set_data(array('status' => Model_App_Queue::ERROR))->save();
		}

		// The child process
		else if ($pid == 0)
			$this->_execute($job);

		return TRUE;
	}

	/**
	 * Fetch job into the queue
	 *
	 * @param {MongoCursor} $tail
	 */
	public function fetch ( $tail )
	{
		// The tailable cursor is the queue
		$queue = $tail;

		// Return if no job available
		if (!$queue->hasNext())
			return;

		// Get the next job
		$job = $queue->getNext();

		// Get the job id
		$job_id = (string) $job['_id'];

		// Success or not ?
		$success = TRUE;

		// Run the job
		switch ($job['status'])
		{
			case Model_App_Queue::DONE:
				break;

			case Model_App_Queue::EXEC:
				break;

			case Model_App_Queue::WAIT:
				$success = $this->execute($job_id);
				break;
		}

		return $success;
	}

	/**
	 * Add a task into the queue
	 */
	public function push ( $task, $data = array() )
	{
		// Create a job
		$job = Model::factory('App_Queue');

		// Build the data object
		$data = array(
			'data' => $data,
			'task' => $task
		);

		// Save the job into the queue
		$job->set_data($data)->save();

		return $job;
	}

	/**
	 * Get tailable cursor
	 *
	 * @erturn {MongoCursor}
	 */
	public function tail ()
	{
		return Model::factory('App_Queue')->tail();
	}

	/**
	 * Execute the task of a job
	 *
	 * @param {Model_App_Queue} $job
	 */
	private function _execute ( $job )
	{
		// Get the task
		$task = (string) $job->task;

		// Get the data
		$data = (array) $job->data;

		// This is the commande
		$command = 'php '.DOCROOT.'index.php --task='.$job->task;

		// This is options to passed to the command
		$options = '';

		// Adjust data
		if (is_null($data) || !is_array($data))
			$data = array();

		// Build option chain
		foreach ($data as $key => $value)
			$options .= ' --'.$key.'='.$value;

		// Set options to the commande
		$command .= $options;

		// Run the commande
		$result = Task_App::execute_shell($command);

		// Log the output if necessary
		if ($result['error'])
			Kohana::$log->add(Log::ERROR, implode("\n", $result['output']));

		exit($result['status']);
	}

} // End SampleApp_Service_Queue
