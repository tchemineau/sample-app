<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Api service class
 */
class SampleApp_Service_Api extends Service
{

	public static $SUCCEED = 'success';

	public static $FAILED = 'failure';

	private static $_account = null;

	/**
	 * Build a standard response
	 *
	 * @param {string} $status
	 * @param {string} $message
	 * @param {array} $data
	 * @param {array} $errors
	 * @return {array}
	 */
	public static function build_response ( $status, $message = '', $data = array(), $errors = array() )
	{
		return array(
			'status' => $status,
			'message' => $message,
			'data' => $data,
			'error' => $errors
		);
	}

	/**
	 * Build a standard response
	 *
	 * @param {string} $message
	 * @param {array} $data
	 * @param {array} $errors
	 * @return {array}
	 */
	public static function build_response_failed ( $message = '', $data = array(), $errors = array() )
	{
		return self::build_response(self::$FAILED, $message, $data, $errors);
	}

	/**
	 * Build a standard response
	 *
	 * @param {string} $message
	 * @param {array} $data
	 * @param {array} $errors
	 * @return {array}
	 */
	public static function build_response_succeed ( $message = '', $data = array(), $errors = array() )
	{
		return self::build_response(self::$SUCCEED, $message, $data, $errors);
	}

	/**
	 * Check access to a resource by an other
	 *
	 * @param {Model_Mongo} $to
	 * @param {Model_Mongo} $by
	 */
	public static function check_access ( $to, $by )
	{
		if ($to->id() != $by->id())
			throw Service_Exception::factory('PermissionDenied', 'Permission denied')->data(array(
				'to' => $to, 'by' => $by));
	}

	/**
	 * Check if a valid token is found and return corresponding account
	 *
	 * @param {Request_Client} $request
	 * @return {Modal_App_Account}
	 */
	public static function check_token ( $request )
	{
		// Get authorization header
		$token = $request->headers('Authorization');

		// Build data
		$data = array('token' => $token);

		// Get account service
		$account_service = Service::factory('Account');

		// Try to authenticate the user
		self::$_account = $account_service->authenticate($data, false);

		return self::$_account;
	}

	/**
	 * Get the last checked account
	 */
	public static function get_account ()
	{
		if (is_null(self::$_account))
			throw Service_Exception::factory('NotFound', 'Api account not found');

		return self::$_account;
	}

} // End SampleApp_Service_Api

