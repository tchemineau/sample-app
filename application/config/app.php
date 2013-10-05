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
	'name' => 'Sample-App',

	// Enable email feature
	'email_enabled' => true,

	// Email sender address
	'email_from_address' => 'no-reply@example.com',

	// Email sender name
	'email_from_name' => 'Sample-App',

	// This is application module that should be loaded at initialization
	'module' => array(

		// 'auth'       => MODPATH.'auth',       // Basic authentication
		// 'cache'      => MODPATH.'cache',      // Caching with multiple backends
		// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
		// 'database'   => MODPATH.'database',   // Database access
		// 'image'      => MODPATH.'image',      // Image manipulation
		// 'orm'        => MODPATH.'orm',        //  Object Relationship Mapping
		// 'unittest'   => MODPATH.'unittest',   // Unit testing
		// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation

		// Load module that need routing
		'assets' => dirname(APPPATH).'/vendor/kohana-assets',

		// Load the sampleapp module
                'sampleapp' => dirname(APPPATH).'/modules/sampleapp',

		// Finaly load additionnal module that do not need routing
		'browser' => dirname(APPPATH).'/vendor/kohana-browser',
		'email' => dirname(APPPATH).'/vendor/kohana-email',
		'minion' => MODPATH.'minion',
		'mongodb' => dirname(APPPATH).'/vendor/kohana-mongodb',
		'password' => dirname(APPPATH).'/vendor/kohana-password',
		'restful' => dirname(APPPATH).'/vendor/kohana-restful',
		'twig' => dirname(APPPATH).'/vendor/kohana-twig',
	),

	// Token expiration time (in seconds)
	'token_timeout' => 604800,

	// Confirm email timeout (in seconds)
	'token_timeout_confirmemail' => 10800,

	// Reset password timeout (in seconds)
	'token_timeout_resetpassword' => 10800,

	// Tracking Google Analytics
	'tracking_ga' => false,
	// 'tracking_ga' => array (
	//	'domain' => 'example.com',
	//	'id' => 'UA-00000000-0'
	// ),

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

