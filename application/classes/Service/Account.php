<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A service class to manage accounts
 */
class Service_Account extends Service
{

	/**
	 * Mail titles
	 */
	private static $_mail_titles = array (
		'CREATE' => '',
		'REMOVE' => ''
	);

	/**
	 * Just used to set mail titles correctly
	 */
	public function __construct ()
	{
		self::$_mail_titles = array (
			'CREATE' => 'Welcome to '.Kohana::$config->load('app.name'),
			'REMOVE' => 'Goodbye from '.Kohana::$config->load('app.name')
		);
	}

	/**
	 * Authenticate user
	 *
	 * @param {array} $data
	 * @return {Model_App_Account}
	 */
	public function authenticate ( array $data )
	{
		// Get the account
		$account = $this->get($data);

		// If token found, then authenticate throw token
		if (isset($data['token']))
		{
			if (!$account->validate_token($data['token']))
				throw Service_Exception::factory('AuthError', 'Token authentication failed');
		}
		// Else, check password authentication
		else if (isset($data['password']))
		{
			if (!$account->validate_password($data['password']))
				throw Service_Exception::factory('AuthError', 'Standard authentication failed');
		}
		// Missing authentication parameter
		else
			throw Service_Exception::factory('AuthError', 'Invalid authentication scheme');

		return $account;
	}

	/**
	 * Create a user account
	 *
	 * @param {array} $data
	 * @return {Model_App_Account}
	 */
	public function create ( array $data )
	{
		// This will store the account model
		$account = Model::factory('App_Account');

		// Check if the account already exists
		try
		{
			$account = $this->get($data);

			throw Service_Exception::factory('AlreadyExists', 'Account :email already exists',
				array(':email' => $data['email']));
		}
		// Catch NotFound exception
		catch (Service_Exception_NotFound $e) {}

		// If nothing wrong, save data
		$account->set_data($data)->save();

		// Could not create account if mail is not sent
		if (!$this->_send_email($account, 'CREATE'))
		{
			$account->remove();

			throw Service_Exception::factory('UnknownError', 'Unable to send email to :email',
				array(':email' => $data['email']));
		}

		return $account;
	}

	/**
	 * Get a user account
	 *
	 * @param {array} $data
	 * @return {Model_App_Account}
	 */
	public function get ( array $data )
	{
		// Get the account model
		$account = Model::factory('App_Account');

		// Validate data according to account model rules
		$validation = $account->validate_data($data);

		// If validation failed, return the appropriate errors
		if (!$validation['status'])
			throw Service_Exception::factory('InvalidData', 'Account data validation failed')->data($validation['errors']);

		// Try to load by resource identifier
		if (isset($data['id']))
			$account->load($data['id']);

		// Try to load the account by token
		else if (isset($data['token']))
			$account->load_by_token($data['token']);

		// Try to load the account by email
		else if (isset($data['email']))
			$account->load_by_email($data['email']);

		// Raise an exception if account could not be loaded
		if (!$account->loaded())
			throw Service_Exception::factory('NotFound', 'Account not found')->data($data);

		return $account;
	}

	/**
	 * Delete a user account
	 *
	 * @param {Model_App_Account}
	 * @return {boolean}
	 */
	public function remove ( $account )
	{
		$account_tmp = $account;

		if (!$account->remove())
			throw Service_Exception::factory('UnknownError', $account->last_error());

		// Could not create account if mail is not sent
		if (!$this->_send_email($account_tmp, 'REMOVE'))
		{
			throw Service_Exception::factory('UnknownError', 'Unable to send email to :email',
				array(':email' => $account_tmp->email));
		}

		return TRUE;
	}

	/**
	 * Update a user account
	 *
	 * @param {App_Model_Account} $account
	 * @param {array} $data
	 * @return {Model_App_Account}
	 */
	public function update ( $account, array $data )
	{
		unset($data['id']);

		if (!$account->set_data($data)->save())
			throw Service_Exception::factory('InvalidData', $account->last_error());

		return $account;
	}

	/**
	 * Send a mail to an account
	 *
	 * @param {Model_App_Account} $account
	 * @param {string} $type
	 * @return {boolean}
	 */
	private function _send_email ( $account, $type )
	{
		// This is the mail title
		$title = self::$_mail_titles[$type];

		// Get the email service
		$email = Service::factory('Email');

		// Build headers
		$headers = $email->build_headers($account->email, $title);

		// Build content
		$content = $email->build_content(
			'Account.'.ucwords(strtolower($type)),
			array(
				'id' => $account->id(),
				'email' => $account->email,
				'firstname' => $account->firstname,
				'lastname' => $account->lastname
			)
		);

		return $email->send($headers, $content);
	}

}

