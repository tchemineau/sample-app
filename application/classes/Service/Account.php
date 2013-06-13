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
		'FORGOT_PASSWORD' => '',
		'REMOVE' => ''
	);

	/**
	 * Just used to set mail titles correctly
	 */
	public function __construct ()
	{
		$app_name = Kohana::$config->load('app.name');

		self::$_mail_titles = array (
			'CREATE' => 'Welcome to '.$app_name,
			'FORGOT_PASSWORD' => 'How to reset your password on '.$app_name,
			'REMOVE' => 'Goodbye from '.$app_name
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
		// This will store the account
		$account = NULL;

		// If token found, then authenticate throw token
		if (isset($data['token']))
		{
			$token = Service::factory('Token')->get($data['token']);

			if (!$token->is_valid())
				throw Service_Exception::factory('AuthError', 'Token authentication failed');

			$account = $this->get(array('id' => $token->target_id));
		}

		// Else, check password authentication
		else if (isset($data['password']))
		{
			$account = $this->get($data);

			if (!$account->validate_password($data['password']))
				throw Service_Exception::factory('AuthError', 'Standard authentication failed');
		}

		// Missing authentication parameter
		else
			throw Service_Exception::factory('AuthError', 'Invalid authentication scheme');

		// Check if the email have been confirmed
		if (!$account->email_verified)
			throw Service_Exception::factory('AuthError', 'Email has not been verified');

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

		// If nothing wrong, save account data
		$account->set_data($data)->save();

		// Create a new auth token for this account
		$token = Service::factory('Token')->create($account, true);

		// Could not create account if mail is not sent
		if (!$this->_send_email($account, 'CREATE'))
		{
			$account->remove();
			$token->remove();

			throw Service_Exception::factory('UnknownError', 'Unable to send email to :email',
				array(':email' => $data['email']));
		}

		return $account;
	}

	/**
	 * Send reset password instruction by mail if account exists
	 *
	 * @param {array} $data
	 * @return {Model_App_Account}
	 */
	public function forgot_password ( array $data )
	{
		// Get the account
		$account = $this->get($data);

		// Create a temporary token
		$token = Service::factory('Token')->create($account, false, Kohana::$config->load('app.token_timeout_resetpassword'));

		// Could not create account if mail is not sent
		if (!$this->_send_email($account, 'FORGOT_PASSWORD', $token))
		{
			throw Service_Exception::factory('UnknownError', 'Unable to send email to :email',
				array(':email' => $account->email));
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

		// Try to load the account by email
		else if (isset($data['email']))
			$account->load_by_email($data['email']);

		// Raise an exception if account could not be loaded
		if (!$account->loaded())
			throw Service_Exception::factory('NotFound', 'Account not found')->data($data);

		return $account;
	}

	/**
	 * Get an authentication token of a given account
	 *
	 * @return {App_Model_Token}
	 */
	public function get_authentication_token ( $account )
	{
		if (!$account->loaded())
			return FALSE;

		// Get all tokens
		$tokens = Service::factory('Token')->get_all($account, true);

		// If no token found, then raise an error
		if (!isset($tokens[0]))
			throw Service_Exception::factory('NotFound', 'Authentication token not found')->data($account->get_data());

		return $tokens[0];
	}

	/**
	 * Delete a user account
	 *
	 * @param {Model_App_Account}
	 * @return {boolean}
	 */
	public function remove ( $account )
	{
		if (!$account->loaded())
			return FALSE;

		// Clone the account to have information for mail
		$account_tmp = clone $account;

		if (!$account->remove())
			throw Service_Exception::factory('UnknownError', $account->last_error());

		// Remove all tokens associated to this user
		Service::factory('Token')->remove_all($account_tmp);

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
	 * @param {Model_App_Token} $token An optional token
	 * @return {boolean}
	 */
	private function _send_email ( $account, $type, $token = null )
	{
		// This is the mail title
		$title = self::$_mail_titles[$type];

		// Get the email service
		$email = Service::factory('Email');

		// Build headers
		$headers = $email->build_headers($account->email, $title);

		// Build mail template name
		$template = str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($type))));

		// Build data
		$data = array(
			'id' => $account->id(),
			'email' => $account->email,
			'firstname' => $account->firstname,
			'lastname' => $account->lastname
		);

		// Add token id if not null
		if (!is_null($token))
		{
			$data['token'] = $token->id();
			$data['token_timeout'] = $token->timeout;
		}

		// Build content
		$content = $email->build_content('Account.'.$template, $data);

		return $email->send($headers, $content);
	}

}

