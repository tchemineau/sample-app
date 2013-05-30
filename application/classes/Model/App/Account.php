<?php defined('SYSPATH') or die();

class Model_App_Account extends Model
{

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Timestamp of last modification
	 */
	public $date_modified;

	/**
	 * Timestamp of the email verification
	 */
	public $data_verified;

	/**
	 * Email
	 */
	public $email;

	/**
	 * EMail verified ?
	 */
	public $email_verified;

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
		// This is the current time
		$timestamp = time();

		// Email is verified ?
		if (!$this->email_verified)
			$data['email_verified'] = false;

		// If email verification is set, add additionnal values
		if (isset($data['email_verified']))
		{
			$data['email_verified'] = true;
			$data['date_verified'] = $timestamp;
		}

		// If password found, securize it
		if (isset($data['password']))
		{
			if (strlen(trim($data['password'])) == 0)
				unset($data['password']);
			else
				$data['password'] = '**'.Password::instance()->hash($data['password']);
		}

		// Generate API token if necessary
		if (!$this->token || $this->token_expired < $timestamp)
		{
			$data['token'] = Password::instance()->random();
			$data['token_expired'] = $timestamp + Kohana::$config->load('app.token_expiration');
		}

		// Set creation time
		if (!$this->date_created)
			$data['date_created'] = $timestamp;

		// Store the last modification time
		$data['date_modified'] = $timestamp;

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
			'date_created' => $this->date_created,
			'date_modified' => $this->date_modified,
			'email' => $this->email,
			'email_verified' => $this->email_verified,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname
		);
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

			// Firstname, lastname
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
		$hash = preg_replace('/^\*\*/', '', $this->password);

		if ($hash == $this->password)
			return FALSE;

		return Password::instance()->check($hash, $password);
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

