<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This define a REST API
 */
abstract class Controller_Api_Rest extends RESTful_Controller
{

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
