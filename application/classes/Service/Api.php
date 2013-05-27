<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Api service class
 */
class Service_Api extends Service
{

	/**
	 * Build a standard response
	 *
	 * @param {string} $message
	 * @param {string} $status
	 * @param {array} $data
	 * @param {array} $errors
	 * @param {string} $type
	 * @return {array}
	 */
	public static function build_response ( $message = '', $status = 'success', $data = array(), $errors = array(), $type = NULL )
	{
		return array(
			'type' => $type,
			'status' => $status,
			'message' => $message,
			'data' => $data,
			'errors' => $errors
		);
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
		return $account_service->authenticate($data);
	}

}
