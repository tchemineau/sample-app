<?php defined('SYSPATH') or die('No direct script access.');

class SampleApp_Model_App_Token extends Model
{

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Id of the concerned object
	 */
	public $target_id;

	/**
	 * Model type of the target
	 */
	public $target_type;

	/**
	 * Non default timeout
	 */
	public $timeout;

	/**
	 * Type of the token
	 */
	public $type;

	/**
	 * Additionnal information for this token
	 */
	public $info;

	/**
	 * Reserved values to not return
	 */
	protected $_reserved = array();

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

		// Set type
		if (!isset($data['type']))
			$data['type'] = 'default';

		// Set timeout
		if (!isset($data['timeout']))
			$data['timeout'] = Kohana::$config->load('app.token_timeout.'.$data['type']);

		return $data;
	}

	/**
	 * Determine if this token is still valid
	 *
	 * @return {boolean}
	 */
	public function is_valid ()
	{
		if (!$this->loaded())
			return FALSE;

		// This is the current time
		$timestamp = time();

		return $this->date_created + $this->timeout > $timestamp;
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
			'target_id' => $this->target_id,
			'target_type' => $this->target_type,
			'timeout' => $this->timeout,
			'type' => $this->type
		);
	}

	/**
	 * Search by target id and filters.
	 *
	 * Available filters are:
	 *  type
	 *
	 * @param {string} $id
	 * @param {array} $filters
	 * @return {array}
	 */
	public function search_by_target ( $id, $filters = array() )
	{
		// Set default values
		$filters['type'] = isset($filters['type']) ? $filters['type'] : null;

		// Get the collection pointer
		$collection = new Mongo_Collection('App_Token');

		// Build the query
		$query = array('target_id' => $id);

		// Set type
		if (!is_null($filters['type']))
			$query['type'] = $filters['type'];

		return $collection->find($query);
	}

	/**
	 * Search all tokens which are in timeout
	 *
	 * @return {array}
	 */
	public function search_by_timeout ()
	{
		$collection = new Mongo_Collection('App_Token');

		// This is the current time
		$timestamp = time();

		// Build the query filter into JS
		$query_where_js = "function()
		{
			return this.timeout != null && (this.date_created + this.timeout) <= $timestamp;
		}";

		// Now build the query that use the filter
		$query = array('$where' => $query_where_js);

		return $collection->find($query);
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
		{
			$data = $this->format_data($data);
		}

		return $this->values($data);
	}

} // End SampleApp_Model_App_Token

