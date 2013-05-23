<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Core REST API
 */
abstract class Controller_RESTv1_Core extends RESTful_Controller
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
	 * Return a correct response
	 *
	 * @param {array} $response A response build by build_response method
	 * @param {int} $code The HTTP code to return
	 */
	public function response ( $response = NULL, $code = 200 )
	{
		if (is_null($response))
			$response = self::build_response();

		$this->response->headers('Content-Type', 'application/json');
		$this->response->status($code);

		parent::response($response);
	}

}

