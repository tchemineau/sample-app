<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User REST API
 */
class Controller_RESTv1_Account extends RESTful_Controller
{

	public function action_get()
	{
		$this->response->body(json_encode(array(
			'firstname' => 'John',
			'lastname' => 'Doe'
		)));
	}

	public function action_update()
	{
	}

	public function action_create()
	{
		$account = Model::factory('App_Account');
		$account->values($this->request->body());
		$account->save();

		$this->response->status(201);
	}

	public function action_delete()
	{
	}

}

