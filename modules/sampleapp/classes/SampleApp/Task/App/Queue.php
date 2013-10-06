<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is the Queue task.
 * This take will loop for ever and read job from a tailable MongoDB collection.
 * It is based on the work of Laurence Putra Franslay.
 *
 * @see https://github.com/laurenceputra/Codeigniter-Mongo-Queue
 */
class SampleApp_Task_App_Queue extends Task_App
{

	/**
	 * Minion will execute this function.
	 */
	protected function _execute ( array $params )
	{
		$this->process();
	}

	/**
	 * Processing jobs.
	 * This run a infinite loops. This is why it should
	 * only be run through command line.
	 */
	public function process ()
	{
		// Enable circular reference collector
		gc_enable();

		// Save number of cycles
		$cycles = 0;

		// Get Queue service
		$queue_service = Service::factory('Queue');

		// Start the service
		while (true)
		{
			$queue = $queue_service->tail();

			// Wait for incoming jobs into the queue
			while (true)
			{

				// Cleaning things if no jobs
				if (!$queue->hasNext())
				{
					$cycles++;

					if ($cycles > 30)
					{
						$cycles = 0;
						gc_collect_cycles();
					}

					sleep(10);

					// If the queue is dead, then break this cycle
					// and relaunch it
					if ($queue->dead())
						break;
				}

				// If jobs, execute it
				// The Queue service will fork to execute the job
				// The job is a task that will be executed has a
				// command line
				else
					$queue_service->fetch($queue);
			}
		}
	}

} // End of SampleApp_Task_App_Queue
