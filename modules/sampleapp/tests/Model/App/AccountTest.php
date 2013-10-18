<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @covers Model_App_Account
 * @group sampleapp
 */
class AccountTest extends Unittest_TestCase
{

	/**
	 * Test date created data formatting
	 */
	public function testFormatDataWhenCreateAccount_DateCreated ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify
		$this->assertArrayHasKey('date_created', $dataf);
		$this->assertLessThanOrEqual(time(), $dataf['date_created']);
	}

	/**
	 * Test date modified data formatting
	 */
	public function testFormatDataWhenCreateAccount_DateModified ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify
		$this->assertArrayHasKey('date_modified', $dataf);
		$this->assertEquals($dataf['date_modified'], $dataf['date_created']);
	}

	/**
	 * Test account email data formatting
	 */
	public function testFormatDataWhenCreateAccount_Email ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify
		$this->assertArrayHasKey('email', $dataf);
		$this->assertEquals($data['email'], $dataf['email']);
	}

	/**
	 * Test email verified data formatting
	 */
	public function testFormatDataWhenCreateAccount_EmailVerified ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify
		$this->assertEquals($dataf['email_verified'], FALSE);
	}

	/**
	 * Test account password data formatting
	 */
	public function testFormatDataWhenCreateAccount_Password ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify
		$this->assertArrayHasKey('password', $dataf);
		$this->assertStringStartsWith('**', $dataf['password']);
	}

	/**
	 * Test account data validation
	 */
	/*
	public function testValidateData ( array $data )
	{
		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

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
	*/

	/**
	 * This is the data provider for testing account data validation
	 */
	/*
	public function providerValidateData ()
	{
		return array(
			array(array(
			)),
			array(array(
			)),
		);
	}
	*/

}

