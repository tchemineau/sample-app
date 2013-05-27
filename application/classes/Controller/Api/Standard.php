<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Standard API
 */
abstract class Controller_Api_Standard extends Controller
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
		$this->response->body(json_encode($response));
	}

}
