<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User REST API
 */
class Controller_RESTv1_Account extends Controller_RESTv1_Core
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

		// Get the account model
		$account = Model::factory('App_Account');

		// Validate data according to account model rules
		$validation = $account->validate_data((array) $data);

		// If validation failed, return the appropriate errors
		if (!$validation['status'])
		{
			return $this->response(self::build_response(
				'Validation failed',
				'failure',
				array(),
				array(
					'error' => $validation['errors']
				)
			), 400);
		}

		// Try to load the account by email (email is mandatory)
		$account->load_by_email($data->email);

		if ($account->loaded())
		{
			return $this->response(self::build_response(
				'Account already exists',
				'failure'
			), 409);
		}

		// Nothing wrong, save data
		$account->values($data)->save();

		// Return appropriate HTTP code
		return $this->response(self::build_response(
			'Account created',
			'success'
		), 201);
	}

	public function action_delete ()
	{
	}

}

