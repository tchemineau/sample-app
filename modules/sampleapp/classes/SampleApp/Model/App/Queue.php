<?php defined('SYSPATH') or die('No direct script access.');

class SampleApp_Model_App_Queue extends Model
{

	/**
	 * Constants relative to status
	 */
	const WAIT  = 'WAITING';  // The job is waiting to be executed
	const EXEC  = 'EXECUTE';  // The job is in progress
	const DONE  = 'SUCCESS';  // The job is done
	const ERROR = 'INERROR';  // The job is in error

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Timestamp of last update
	 */
	public $date_updated;

	/**
	 * This is data of the job
	 */
	public $data;

	/**
	 * Status of the job
	 */
	public $status;

	/**
	 * The task of this job
	 */
	public $task;

	/**
	 * Reserved values to not return
	 */
	protected $_reserved = array();

	/**
	 * This will create a capped collection.
	 */
	public function __construct ( $model, $id = NULL, $config = 'default' )
	{
		parent::__construct($model, $id, $config);

		// Get the database
		$db = Mongo_Connection::instance($config)->db();

		// The full name of this collection
		$name = $db.'.'.$this->_model;

		// Check if the collection exists
		// If not, create a capped one
		if ($db->system->namespaces->findOne(array('name' => $name)) === null)
		{
			$db->command(array(
				'create' => $this->_model,
				'capped' => TRUE,
				'size' => 10*1024,
				'max' => 1000
			));
		}
	}

	/**
	 * Format values
	 *
	 * @param {array} $data
	 * @return {array}
	 */
	public function format_data ( array $data )
	{
		// This is the current time
		$timestamp = time();

		// Set creation time
		if (!$this->date_created)
			$data['date_created'] = $timestamp;

		// Set status
		if (!isset($data['status']))
			$data['status'] = self::WAIT;

		// Store the last update time
		$data['date_updated'] = $timestamp;

		return $data;
	}

	/**
	 * Get loaded data
	 *
	 * @return {array}
	 */
	public function get_data ()
	{
		if (!$this->loaded())
			return array();

		return array(
			'id' => $this->id(),
			'date_created' => $this->date_created,
			'date_updated' => $this->date_updated,
			'data' => $this->data,
			'status' => $this->status,
			'task' => $this->task
		);
	}

	/**
	 * Set data
	 *
	 * @param {array} $data
	 * @param {boolean} $format
	 */
	public function set_data ( array $data, $format = true )
	{
		if ($format)
			$data = $this->format_data($data);

		return $this->values($data);
	}

	/**
	 * Return a tailable cursor on the queue
	 *
	 * @return {MongoCursor}
	 */
	public function tail ()
	{
		// Return a tailable cursor on the queue
		return $this->_collection->find()->tailable();
	}

} // End SampleApp_Model_App_Queue
