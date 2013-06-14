<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('api_v1_auth', 'api/v1/auth(/<action>)')
	->defaults(array(
		'action'     => 'index',
		'controller' => 'Auth',
		'directory'  => 'Api/V1'
	));

Route::set('api_v1', 'api/v1/(<controller>(/<id>))')
	->defaults(array(
		'directory'  => 'Api/V1'
	));

Route::set('default', '<fragment>',array(
		'fragment' => '.*'
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'welcome'
	));

