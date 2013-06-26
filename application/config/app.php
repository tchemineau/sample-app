<?php defined('SYSPATH') or die('No direct script access.');

/**
 * !! This is default settings.
 * !! To configure your settings, please do it into app.local.php
 */
$config = array(

	// Base URL of the application
	'base_url' => '/sample-app/',

	// Application name
	'name' => 'Sample App',

	// Enable email feature
	'email_enabled' => true,

	// Email sender address
	'email_from_address' => 'no-reply@example.com',

	// Email sender name
	'email_from_name' => 'Sample App',

	// Token expiration time (in seconds)
	'token_timeout' => 604800,

	// Reset password timeout (in seconds)
	'token_timeout_resetpassword' => 10800

);

/**
 * !! This will load local settings.
 */
if (file_exists(APPPATH.'config/app.local.php'))
{
        require_once APPPATH.'config/app.local.php';
        $config = array_merge($config, $local);
        unset($local);
}

/**
 * Return configuration
 */
return $config;

