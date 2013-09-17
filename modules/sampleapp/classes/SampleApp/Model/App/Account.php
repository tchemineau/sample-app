<?php defined('SYSPATH') or die('No direct script access.');

class SampleApp_Model_App_Account extends Model
{

	/**
	 * Timestamp of creation
	 */
	public $date_created;

	/**
	 * Timestamp of last connexion
	 */
	public $date_lastvisit;

	/**
	 * Timestamp of last modification
	 */
	public $date_modified;

	/**
	 * Timestamp of the email verification
	 */
	public $date_verified;

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
	 * Gravatar email
	 */
	public $gravatar_email;

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

		// Set creation time
		if (!$this->date_created)
			$data['date_created'] = $timestamp;

		// Set last visit time
		if (!$this->date_lastvisit)
			$data['date_lastvisit'] = $timestamp;

		// Set default email_verified values
		if (!$this->email_verified)
			$data['email_verified'] = false;

		// Check email verification
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

		// Store the last modification time
		$data['date_modified'] = $timestamp;

		return $data;
	}

	/**
	 * Get public loaded data
	 *
	 * @return {array}
	 */
	public function get_data ()
	{
		if (!$this->loaded())
			return array();

		// Return data
		return array(
			'id' => $this->id(),
			'date_created' => $this->date_created,
			'date_lastvisit' => $this->date_lastvisit,
			'date_modified' => $this->date_modified,
			'email' => $this->email,
			'email_verified' => $this->email_verified,
			'firstname' => $this->firstname,
			'gravatar_email' => $this->gravatar_email,
			'gravatar_url' => $this->gravatar_email ? 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($this->gravatar_email))).'?d=mm&s=64&r=g' : null,
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
	 * Set data
	 *
	 * @param {array} $data
	 * @param {boolean} $format
	 */
	public function set_data ( array $data, $format = true )
	{
		// Unset
		unset($data['gravatar_url']);

		// Format
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
			->rule('gravatar_email', 'email')

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

} // End SampleApp_Model_App_Account

