<?php defined('SYSPATH') or die('No direct script access.');

/**
 * !! This is default settings.
 * !! To configure your settings, please do it into app.local.php
 */
$config = array(

	// Base URL of the application
	'base_url' => '/sample-app/',

	// Cookie salt
	'cookie_salt' => 'foobar',

	// Application name
	'name' => 'Sample App',

	// Enable email feature
	'email_enabled' => true,

	// Email sender address
	'email_from_address' => 'no-reply@example.com',

	// Email sender name
	'email_from_name' => 'Sample App',

	// This is application module that should be loaded at initialization
	'module' => array(

		// 'auth'       => MODPATH.'auth',       // Basic authentication
		// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
		// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
		// 'database'   => MODPATH.'database',   // Database access
		// 'image'      => MODPATH.'image',      // Image manipulation
		// 'minion'     => MODPATH.'minion',     // CLI Tasks
		// 'orm'	=> MODPATH.'orm',	// Object Relationship Mapping
		// 'unittest'   => MODPATH.'unittest',   // Unit testing
		// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation

		'assets' => dirname(APPPATH).'/vendor/kohana-assets',
		'browser' => dirname(APPPATH).'/vendor/kohana-browser',
		'email' => dirname(APPPATH).'/vendor/kohana-email',
		'mongodb' => dirname(APPPATH).'/vendor/kohana-mongodb',
		'password' => dirname(APPPATH).'/vendor/kohana-password',
		'restful' => dirname(APPPATH).'/vendor/kohana-restful',
		//'smarty3' => dirname(APPPATH).'/vendor/kohana-smarty3',
		'twig' => dirname(APPPATH).'/vendor/kohana-twig',

		// This module have to be loaded at the end because of routing.
		'sampleapp' => dirname(APPPATH).'/modules/sampleapp'
	),

	// Token expiration time (in seconds)
	'token_timeout' => 604800,

	// Confirm email timeout (in seconds)
	'token_timeout_confirmemail' => 10800,

	// Reset password timeout (in seconds)
	'token_timeout_resetpassword' => 10800

);

/**
 * !! This will load local settings.
 */
if (file_exists(APPPATH.'config/app.local.php'))
{
	require_once APPPATH.'config/app.local.php';
	$config = array_merge_recursive($config, $local);
	unset($local);
}

/**
 * Return configuration
 */
return $config;

