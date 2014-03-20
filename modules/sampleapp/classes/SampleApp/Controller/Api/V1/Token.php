<?php defined('SYSPATH') or die('No direct script access.');

/**
 * REST API to access to token
 */
class SampleApp_Controller_Api_V1_Token extends Controller_Api_Rest
{

	/*
	 * Create a token
	 */
	public function action_create ()
	{
		// Get data from the body sent by backbone
		$body = $this->request->body();

		// Get the token service
		$token_service = Service::factory('Token');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Get the current user account
			$account = $api_service->get_account();

			// Create the token
			$token = Service::factory('Token')->create($account, array(
				'info' => $body->info,
				'type' => 'api'
			));

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Token created',
				array(
					'id' => $token->id(),
					'date_created' => $token->date_created,
					'info' => $token->info
				)
			), 201);
		}
		catch (Service_Exception_AlreadyExists $e)
		{
			$this->response($api_service->build_response_failed($e->getMessage()), 409);
		}
		catch (Service_Exception_InvalidData $e)
		{
			$this->response($api_service->build_response_failed(
				$e->getMessage(),
				array(),
				array(
					'error' => $e->data()
				)
			), 400);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response_failed($e->getMessage()), 400);
		}
	}

} // End SampleApp_Controller_Api_V1_Token

