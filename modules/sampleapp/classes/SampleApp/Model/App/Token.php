<?php defined('SYSPATH') or die('No direct script access.');

class SampleApp_Model_App_Token extends Model
{

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Is the token permanent ?
	 */
	public $is_permanent;

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

		// Set persistent token or not
		if (!isset($data['is_permanent']))
			$data['is_permanent'] = false;

		// Set type
		if (!isset($data['type']))
			$data['type'] = 'app';

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

		// Get the expiration time
		$timeout = Kohana::$config->load('app.token_timeout');

		// This is the current time
		$timestamp = time();

		return $this->is_permanent || $this->date_created + $timeout > $timestamp;
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
			'is_permanent' => $this->permanent,
			'target_id' => $this->target_id,
			'target_type' => $this->target_type,
			'type' => $this->type
		);
	}

	/**
	 * Search by target id and filters.
	 *
	 * Available filters are:
	 *  only_permanent = false
	 *  only_temporary = false
	 *  type = 'app'
	 *
	 * @param {string} $id
	 * @param {array} $filters
	 * @return {array}
	 */
	public function search_by_target ( $id, $filters = array() )
	{
		// Set default values
		$filters['only_permanent'] = isset($filters['only_permanent']) ? $filters['only_permanent'] : false;
		$filters['only_temporary'] = isset($filters['only_temporary']) ? $filters['only_temporary'] : false;
		$filters['type'] = isset($filters['type']) ? $filters['type'] : null;

		// Get the collection pointer
		$collection = new Mongo_Collection('App_Token');

		// Build the query
		$query = array('target_id' => $id);

		// If we want only permanent tokens or not
		if ($filters['only_permanent'])
			$query['is_permanent'] = true;

		// If wen want only temporary token
		if ($filters['only_temporary'])
			$query['is_permanent'] = false;

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

