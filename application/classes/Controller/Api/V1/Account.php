<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User REST API
 */
class Controller_Api_V1_Account extends Controller_Api_V1_Core
{

	public function action_get ()
	{
		return $this->response(self::build_response(
			'Account exists',
			'success',
			array(
				'firstname' => 'John',
				'lastname' => 'Doe'
			)
		));
	}

	public function action_update ()
	{
	}

	public function action_create ()
	{
		// Get data from the body sent by backbone
		$data = $this->request->body();

		// Get the account service
		$account = Service::factory('Account');

		try
		{
			// Create the account
			$account->create((array) $data);

			// Return appropriate HTTP code
			$this->response(self::build_response(
				'Account created',
				'success'
			), 201);
		}
		catch (Service_Exception_AlreadyExists $e)
		{
			$this->response(self::build_response(
				$e->getMessage(),
				'failure'
			), 409);
		}
		catch (Service_Exception_InvalidData $e)
		{
			$this->response(self::build_response(
				$e->getMessage(),
				'failure',
				array(),
				array(
					'error' => $e->data()
				)
			), 400);
		}
	}

	public function action_delete ()
	{
	}

}

