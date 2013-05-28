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
	 * Token
	 */
	public $token;

	/**
	 * Token expiration date
	 */
	public $token_expired;

	/**
	 * Reserved values to not return
	 */
	protected $_reserved = array();

	/**
	 * Format values
	 *
	 * @param {array} $data
	 * @return {array}
	 */
	public function format_data ( array $data )
	{
		if (isset($data['password']))
		{
			$data['password'] = Password::instance()->hash($data['password']);
		}

		return $data;
	}

	/**
	 * Get loaded data
	 *
	 * @return {array}
	 */
	public function get_data ()
	{
		if (!$this->loaded())
			return array();

		return array(
			'id' => $this->id(),
			'email' => $this->email,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname
		);
	}

	/**
	 * Return user token
	 *
	 * @return {string}
	 */
	public function get_token ()
	{
		return $this->token;
	}

	/**
	 * Load by email address
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
	 * Load by token
	 *
	 * @param {string} $token
	 */
	public function load_by_token ( $token )
	{
		$response = $this->_collection->findOne(array('token' => $token));

		if ($response)
		{
			$this->values($response);
			$this->_loaded = true;
		}

		return $this;
	}

	/**
	 * Set data
	 *
	 * @param {array} $data
	 * @param {boolean} $format
	 */
	public function set_data ( array $data, $format = true )
	{
		if ($format)
		{
			$data = $this->format_data($data);
		}

		// This is the current time
		$timestamp = time();

		// Generate API token if necessary
		if (!$this->token || $this->token_expired < $timestamp)
		{
			$data['token'] = Password::instance()->random();
			$data['token_expired'] = $timestamp + Kohana::$config->load('app.token_expiration');
		}

		// Set values
		return $this->values($data);
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

			// Email address
			->rule('email', 'email')

			// Password
			->rule('password', 'min_length', array(':value', 8))

			// Firstname, lastname, displayname and pseudo
			->rule('firstname', 'regex', array(':value', '/[-\w.,+]+/'))
			->rule('lastname', 'regex', array(':value', '/[-\w.,+]+/'));

		return array(
			'status' => $validation->check(),
			'errors' => $validation->errors()
		);
	}

	/**
	 * Validate the given password against the current password
	 *
	 * @param {string} $password
	 * @return {boolean}
	 */
	public function validate_password ( $password )
	{
		return Password::instance()->check($this->password, $password);
	}

	/**
	 * Validate the given token against the token password
	 *
	 * @param {string} $token
	 * @return {boolean}
	 */
	public function validate_token ( $token )
	{
		$timestamp = time();

		return $this->token && $this->token_expired > $timestamp && $this->token == $token;
	}

}

