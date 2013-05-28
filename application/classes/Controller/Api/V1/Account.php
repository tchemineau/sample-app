<?php defined('SYSPATH') or die('No direct script access.');

/**
 * REST API to manage account
 */
class Controller_Api_V1_Account extends Controller_Api_Rest
{

	public function action_get ()
	{
		// Get account id
		$id = $this->request->param('id');

		// Get the account service
		$account_service = Service::factory('Account');

		// Get api service
		$api_service = Service::factory('Api');

		try
		{
			// Create the account
			$account = $account_service->get(array('id' => $id));

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Account found',
				$account->get_public_vars() + array('id' => $id)
			), 201);
		}
		catch (Exception $e)
		{
			$this->response($api_service->build_response_failed($e->getMessage()), 400);
		}
	}

	public function action_update ()
	{
	}

	public function action_create ()
	{
		// Get data from the body sent by backbone
		$data = $this->request->body();

		// Get the account service
		$account_service = Service::factory('Account');

		// Get the api service
		$api_service = Service::factory('Api');

		try
		{
			// Create the account
			$account = $account_service->create((array) $data);

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Account created',
				$account->get_public_vars() + array('id' => $id)
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
			$this->response($api_service->build_response_failed($e->getMessage()), 400);
		}
	}

	public function action_delete ()
	{
	}

}

