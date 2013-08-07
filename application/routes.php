<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('api_v1_app', 'api/v1/app(/<action>)')
	->defaults(array(
		'action'     => 'index',
		'controller' => 'App',
		'directory'  => 'Api/V1'
	));

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

Route::set('default', '<fragment>', array(
		'fragment' => '.*'
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'welcome'
	));

/**
 * Set routes of javascript modules
 */

Service::factory('Application')->set_js_route('module/account/router',
	array(
		'account',
		'account/confirm/<token>',
		'account/create',
		'account/forgot_password',
		'account/reset_password/<token>'
	),
	array(
		'token' => '.*'
	)
);

