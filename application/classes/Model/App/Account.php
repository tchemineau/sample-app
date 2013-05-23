<?php defined('SYSPATH') or die();

class Model_App_Account extends Model
{

	/**
	 * Email
	 */
	public $email;

	/**
	 * Firstname
	 */
	public $firstname;

	/**
	 * Lastname
	 */
	public $lastname;

	/**
	 * Password
	 */
	public $password;

	/**
	 * Reserved values to not return
	 */
	public $_reserved = array();

	/**
	 * Format values
	 *
	 * @param {array} $data
	 * @return {array}
	 */
	public static function format_data ( array $data )
	{
		if (isset($data['password']))
		{
			$data['password'] = Password::instance()->hash($data['password']);
		}

		return $data;
	}

	/**
	 * Load by email address ?
	 *
	 * @param {string} $email
	 */
	public function load_by_email ( $email )
	{
		$response = $this->_collection->findOne(array('email' => $email));

		if ($response)
		{
			$this->values($response);
			$this->_loaded = true;
		}

		return $this;
	}

	/**
	 * Set values
	 *
	 * @param {array} $data
	 * @param {boolean} $format
	 */
	public function values ( $data, $format = true )
	{
		if ($format)
		{
			$data = $this->format_data((array) $data);
		}

		return parent::values((array) $data);
	}

	/**
	 * Validate data.
	 *
	 * @param {array} $data
	 * @return {array}
	 */
	public static function validate_data ( array $data )
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

		return array(
			'status' => $validation->check(),
			'errors' => $validation->errors()
		);
	}

}

