<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This define a REST API
 */
abstract class SampleApp_Controller_Api_Rest extends RESTful_Controller
{

	/**
	 * Actions that need restriction by token authentication
	 */
	protected $_action_restricted = array(
		HTTP_Request::GET,
		HTTP_Request::PUT,
		HTTP_Request::POST,
		HTTP_Request::DELETE
	);

	/**
	 * Reroute to null action
	 */
	public function action_nothing () {}

	/**
	 * Do things
	 */
	public function before ()
	{
		parent::before();

		// Check authentication token
		$this->check_token();
	}

	/**
	 * Verify that authentication token is valid
	 */
	public function check_token ()
	{
		// Get API service
		$api_service = Service::factory('Api');

		// Get HTTP method
		$method_override = $this->request->headers('X-HTTP-Method-Override');
		$method = strtoupper((empty($method_override)) ? $this->request->method() : $method_override);

		try
		{
			if (in_array($method, $this->_action_restricted))
				$api_service->check_token($this->request);
		}
		catch (Service_Exception_AuthError $e)
		{
			$this->request->action('nothing');
			$this->response($api_service->build_response_failed($e->getMEssage()), 401);
		}
		catch (Service_Exception_NotFound $e)
		{
			$this->request->action('nothing');
			$this->response($api_service->build_response_failed($e->getMEssage()), 401);
		}
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
			$response = Service::factory('Api')->build_response_succeed();

		$response['code'] = $code;

		$this->response->headers('Content-Type', 'application/json');
		$this->response->status($code);

		parent::response($response);
	}

} // End SampleApp_Controller_Api_Rest

