<?php defined('SYSPATH') or die();

/**
 * !! This is default settings.
 * !! To configure your settings, please do it into app.local.php
 */
$config = array(
	'default' => array(
		'host' => 'localhost',
		'port' => 27017,
		'database' => 'sample-app',
		'username' => '',
		'password' => '',
	),
);

/**
 * !! This will load local settings.
 */
if (file_exists(APPPATH.'config/mongodb.local.php'))
{
	require_once APPPATH.'config/mongodb.local.php';
	$config = array_merge($config, $local);
	unset($local);
}

/**
 * Return configuration
 */
return $config;

