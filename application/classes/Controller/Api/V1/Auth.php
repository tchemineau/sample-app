<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Simple authentication API
 */
class Controller_Api_V1_Auth extends Controller_Api_Standard
{

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

			// Return appropriate HTTP code
			$this->response($api_service->build_response(
				'Authentication succeed',
				'success',
				array(
					'token' => $account->token
				)
			), 201);
		}
		catch (Service_Exception_AuthError $e)
		{
			$this->response($api_service->build_response(
				$e->getMessage(),
				'failure'
			), 401);
		}
		catch (Exception $e)
		{
			var_dump($e);
			$this->response($api_service->build_response(
				'Bad authentication request',
				'failure'
			), 400);
		}
	}

}
