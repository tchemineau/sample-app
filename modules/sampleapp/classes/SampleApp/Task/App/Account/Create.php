<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Task to create a new account
 *
 * It can accept the following options:
 *  - email: the email of the account. It is required.
 *  - password: the password of the account. It is required.
 */
class SampleApp_Task_App_Account_Create extends Task_App
{

	/**
	 * Available options
	 * @var
	 */
	protected $_options = array(
		'email' => NULL,
		'password' => NULL,
	);

	/**
	 * Sample-App will execute this function.
	 */
	protected function _execute ( array $params )
	{
		// Get email
		$email = $params['email'];

		// Get password
		$password = $params['password'];

		// Process
		$this->process($email, $password);
	}

	/**
	 * Validate inputs
	 */
	public function build_validation ( Validation $validation )
	{
		return parent::build_validation($validation)
			->rule('email', 'not_empty')
			->rule('password', 'not_empty');
	}

	/**
	 * Process to account creation
	 */
	public function process ( $email, $password )
	{
		// Get the account service
		$account_service = Service::factory('Account');

		// Create the account
		$account = $account_service->create(array(
			'email' => $email,
			'password' => $password));

		// Confirm the account
		$account = $account_service->update($account, array('email_verified' => TRUE));
	}

} // End of SampleApp_Task_App_Account_Create

