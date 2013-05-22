<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User REST API
 */
class Controller_RESTv1_Account extends RESTful_Controller
{

	public function action_get ()
	{
		$this->response->body(json_encode(array(
			'firstname' => 'John',
			'lastname' => 'Doe'
		)));
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
			$this->response->body(json_encode(array('error' => $validation['errors'])));
			$this->response->status(400);

			return;
		}

		// Try to load the account by email (email is mandatory)
		$account->load_by_email($data->email);

		if ($account->loaded())
		{
			$this->response->status(409);

			return;
		}

		// Nothing wrong, save data
		$account->values($data)->save();

		// Return appropriate HTTP code
		$this->response->status(201);
	}

	public function action_delete ()
	{
	}

}

