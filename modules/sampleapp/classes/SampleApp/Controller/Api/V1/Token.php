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

	/**
	 * Delete a token
	 */
	public function action_delete ()
	{
		// Get account id
		$id = $this->request->param('id');

		// Get the token service
		$token_service = Service::factory('Token');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Get current logged in user account
			$user = $api_service->get_account();

			// Get the token
			$token = $token_service->get($id);

			// Check permissions
			$api_service->check_access($token, $user, 'target_id');

			// Remove it
			$token_service->remove($token);

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Token deleted'
			), 200);
		}
		catch (Service_Exception_NotFound $e)
		{
			$this->response($api_service->build_response_failed($e->getMEssage()), 404);
		}
		catch (Service_Exception_PermissionDenied $e)
		{
			$this->response($api_service->build_response_failed($e->getMEssage()), 403);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response_failed($e->getMessage()), 400);
		}
	}

} // End SampleApp_Controller_Api_V1_Token

