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
	protected $password;

	/**
	 * Token
	 */
	protected $token;

	/**
	 * Token expiration date
	 */
	protected $token_expired;

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
	public static function format_data ( array $data )
	{
		if (isset($data['password']))
		{
			$data['password'] = Password::instance()->hash($data['password']);
		}

		unset($data['token'], $data['token_expired']);

		return $data;
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

		// This is the current time
		$timestamp = time();

		// Generate API token if necessary
		if (!$this->token || $this->token_expired < $timestamp)
		{
			$data['token'] = Password::instance()->random();
			$data['token_expired'] = $timestamp + Kohana::$config->load('app.token_expiration');
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
		$hash = Password::instance()->hash($password);

		return $this->password && $this->password == $hash;
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

