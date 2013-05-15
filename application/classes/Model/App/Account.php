<?php defined('SYSPATH') or die();

class Model_App_Account extends Model
{
	public $_reserved = array();

	public static function validate_data ( $data )
	{
		$validation = Validation::factory($data)

			// Username
			->rule('username', 'min_length', array(':value', 4))
			->rule('username', 'regex', array(':value', '/^[a-zA-Z0-9]+$/iD'))

			// Password
			->rule('password', 'min_length', array(':value', 8))

			// Mail address
			->rule('email', 'email')

			// Firstname, lastname, displayname and pseudo
			->rule('firstname', 'regex', array(':value', '/[-\w.,+]+/'))
			->rule('lastname', 'regex', array(':value', '/[-\w.,+]+/'));

		return $validation->check();
	}

}

