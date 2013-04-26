<?php defined('SYSPATH') or die('No direct script access.');

/**
 * User REST API
 */
class Controller_RESTv1_User extends RESTful_Controller
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
	}

	public function action_delete()
	{
	}

}

