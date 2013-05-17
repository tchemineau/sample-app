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
		$data = $this->request->body();
		$account = Model::factory('App_Account');
		$validation = $account->validate_data((array) $data);

		if ($validation['status'])
		{
			$account->values($data);
			$account->save();

			$this->response->status(201);
		}
		else
		{
			$this->response->body(json_encode(array('error' => $validation['errors'])));
			$this->response->status(400);
		}
	}

	public function action_delete ()
	{
	}

}

