<?php defined('SYSPATH') or die('No direct script access.');

/**
 * !! This is default settings.
 * !! To configure your settings, please do it into config.local.php
 */
$config = array(

	// Email sender address
	'email_from_address' => 'no-reply@example.com',

	// Email sender name
	'email_from_name' => 'Sample App',

);

/**
 * !! This will load local settings.
 */
if (file_exists(APPPATH.'config/config.local.php'))
{
        require_once APPPATH.'config/config.local.php';
        $config = array_merge($config, $local);
}

/**
 * Return configuration
 */
return $config;

