<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Simple authentication API
 */
class Controller_Api_V1_Auth extends Controller_Api_Standard
{

	public function action_forgot_password ()
	{
		// Get request parameters
		$email = $this->request->post('email');

		// Build request data
		$data = array('email' => $email);

		// Get the account service
		$account_service = Service::factory('Account');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Send password reset instructions
			$account = $account_service->forgot_password($data);

			// Return appropriate HTTP result
			$this->response($api_service->build_response_succeed(
				'Forgot password instruction sent'
			), 200);
		}
		catch (Exception $e)
		{
			$this->response($api_service->build_response('Bad request'), 400);
		}
	}

	public function action_index ()
	{
		// Get request parameters
		$email = $this->request->post('email');
		$password = $this->request->post('password');

		// Build request data
		$data = array(
			'email' => $email,
			'password' => $password
		);

		// Get the account service
		$account_service = Service::factory('Account');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Try to authenticate the user
			$account = $account_service->authenticate($data);

			// Get authentication token
			$token = $account_service->get_authentication_token($account);

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Authentication succeed',
				array(
					'id' => $account->id(),
					'token' => $token->id()
				)
			), 200);
		}
		catch (Service_Exception_AuthError $e)
		{
			$this->response($api_service->build_response_failed($e->getMessage()), 401);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response('Bad authentication request'), 400);
		}
	}

	public function action_reset_password ()
	{
		// Get request parameters
		$token = $this->request->post('token');
		$password = $this->request->post('password');

		// Build request data
		$data = array(
			'token' => $token,
			'password' => $password
		);

		// Get the account service
		$account_service = Service::factory('Account');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Send password reset instructions
			$account = $account_service->reset_password($data);

			// Return appropriate HTTP result
			$this->response($api_service->build_response_succeed(
				'Password updated'
			), 200);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response('Bad request'), 400);
		}
	}

}
