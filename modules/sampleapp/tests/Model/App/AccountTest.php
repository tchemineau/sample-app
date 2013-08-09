<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @covers Model_App_Account
 * @group sampleapp
 */
class AccountTest extends Unittest_TestCase
{

	public function testFormatDataWhenCreateAccount ()
	{
		// Build request data
		$data = array(
			'email' => 'test@example.com',
			'password' => 'testtest'
		);

		// Format data request
		$dataf = Model::factory('App_Account')->format_data($data);

		// Verify presence of keys
		$this->assertArrayHasKey('email', $dataf);
		$this->assertArrayHasKey('email_verified', $dataf);
		$this->assertArrayHasKey('password', $dataf);
		$this->assertArrayHasKey('date_created', $dataf);
		$this->assertArrayHasKey('date_modified', $dataf);

		// Verify email
		$this->assertEquals($data['email'], $dataf['email']);
		$this->assertEquals($data['email_verified'], FALSE);

		// Verify password
		$this->assertStringStartsWith('**', $data['password']);

		// Verify dates
		$this->assertLessThanOrEqual(time(), $dataf['date_created']);
		$this->assertEquals($dataf['date_modified'], $dataf['date_created']);
	}

	/*
	public function testValidateData ( array $data )
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
	*/

}

