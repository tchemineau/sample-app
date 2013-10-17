<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A service class to manage tokens
 */
class SampleApp_Service_Token extends Service
{

	/**
	 * Just used to do initialize stuff
	 */
	public function __construct ()
	{
		$this->purge_all();
	}

	/**
	 * Create a token for a given loaded mongo model
	 *
	 * Available default values are:
	 *  is_permanent = false
	 *  timeout = null
	 *
	 * @param {Model_Mongo} $model
	 * @param {array} $values
	 * @return {Model_App_Token}
	 */
	public function create ( $model, $values )
	{
		// Create a new empty token
		$token = Model::factory('App_Token');

		// Build data
		$data = array(
			'target_id' => $model->id(),
			'target_type' => get_class($model)
		);

		// Set info if necessary
		if (isset($values['info']))
			$data['info'] = $values['info'];

		// Set persistent bit
		if (isset($values['is_permanent']) && $values['is_permanent'])
			$data['is_permanent'] = $values['is_permanent'];

		// Set timeout
		if (isset($values['timeout']) && is_int($values['timeout']))
			$data['timeout'] = $values['timeout'];

		// Set type
		if (isset($values['type']))
			$data['type'] = $values['type'];

		// Save data
		$token->set_data($data)->save();

		return $token;
	}

	/**
	 * Get a token from its id
	 *
	 * @param {string} $id
	 * @return {Model_App_Token}
	 */
	public function get ( $id )
	{
		// Create a new empty token
		$token = Model::factory('App_Token');

		// Load the token
		$token->load($id);

		// Raise an exception if account could not be loaded
		if (!$token->loaded())
			throw Service_Exception::factory('NotFound', 'Token not found')->data(array('id' => $id));

		return $token;
	}

	/**
	 * Get a all tokens for a given mongo model
	 *
	 * Available filters are defined into Model_App_Token::search_by_target
	 *
	 * @param {App_Model_Mongo} $model
	 * @param {array} $filters
	 * @return {array}
	 */
	public function get_all ( $model, $filters = array() )
	{
		if (!$model->loaded())
			return array();

		return Model::factory('App_Token')->search_by_target($model->id(), $filters);
	}

	/**
	 * Purge all expired tokens
	 */
	public function purge_all ()
	{
		foreach (Model::factory('App_Token')->search_by_timeout() as $token)
			$this->remove($token);
	}

	/**
	 * Delete a token
	 *
	 * @param {Model_App_Token}
	 * @return {boolean}
	 */
	public function remove ( $token )
	{
		if (!$token->remove())
			throw Service_Exception::factory('UnknownError', $token->last_error());

		return TRUE;
	}

	/**
	 * Delete all token for a given mongo model
	 *
	 * @param {Model_App_Mongo}
	 * @param {array} $filters
	 * @return {boolean}
	 */
	public function remove_all ( $model, $filters = array() )
	{
		foreach ($this->get_all($model, $filters) as $token)
			$this->remove($token);

		return TRUE;
	}

} // End SampleApp_Service_Token

