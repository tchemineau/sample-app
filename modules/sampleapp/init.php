<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Set module routes.
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

Route::set('app_i18n', 'nls/<fragment>', array(
		'fragment' => '.*'
	))
	->defaults(array(
		'action' => 'i18n',
		'controller' => 'Assets',
		'directory' => 'App'
	));

Route::set('app_default', '<fragment>', array(
		'fragment' => '.*'
	))
	->defaults(array(
		'action'     => 'index',
		'controller' => 'Welcome',
		'directory'  => 'App'
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

/**
 * Set javascript module to be load at initialization
 */

Service::factory('Application')->set_js_init('module/account/router');

