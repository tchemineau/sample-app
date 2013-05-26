<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A service class to manage accounts
 */
class Service_Account extends Service
{

	/**
	 * Create a user account
	 *
	 * @param {array} $data
	 * @return {boolean}
	 */
	public static function create ( array $data )
	{
		// Get the account model
		$account = Model::factory('App_Account');

		// Validate data according to account model rules
		$validation = $account->validate_data($data);

		// If validation failed, return the appropriate errors
		if (!$validation['status'])
		{
			throw Service_Exception::factory('InvalidData', 'Account data validation failed')->data($validation['errors']);
		}

		// Try to load the account by email (email is mandatory)
		$account->load_by_email($data['email']);

		if ($account->loaded())
		{
			throw Service_Exception::factory('AlreadyExists', 'Account already exists')->data($validation['errors']);
		}

		// Nothing wrong, save data
		$account->values($data)->save();

		// Send a mail
		if (!$this->_send_email($account, 'Account created'))
		{
			// Cancel account creation
			// Throw exception
		}

		return TRUE;
	}

	/**
	 * Send a mail to an account
	 *
	 * @param {Model_App_Account} $account
	 * @param {string} $title
	 * @return {boolean}
	 */
	private function _send_email ( $account, $title )
	{
		// Get the email service
		$email = Service::factory('Email');

		// Build headers
		$headers = $email->build_headers($account->email, $title);

		// Build content
		$content = $email->build_content(
			'Account.'.ucwords($this->request->action()),
			array(
				'email' => $account->email,
				'firstname' => $account->firstname,
				'lastname' => $account->lastname
			)
		);

		return $email->send($headers, $content);
	}

}

