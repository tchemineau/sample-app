<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Application service class
 */
class Service_Application extends Service
{

	/**
	 * Internal JS routes
	 */
	private static $_js_route = array();

	/**
	 * Return JS route depending of a given URI
	 *
	 * @param {string} $uri An URI
	 */
	public static function get_js_route ( $uri )
	{
		foreach (self::$_js_route as $path => $uris_regex)
		{
			foreach ($uris_regex as $uri_regex)
			{
				if (preg_match($uri_regex, $uri))
					return $path;
			}
		}

		throw Service_Exception::factory('NotFound', 'JS route not found');
	}

	/**
	 * Register uris for a given JS module
	 *
	 * @param {string} $path  Path of the JS module to load
	 * @param {array}  $uris  Valid uris for this module
	 * @param {array}  $regex If $uris contains pattern to detect
	 */
	public static function set_js_route ( $path, array $uris, array $regex = NULL )
	{
		if (!isset(self::$_js_route[$path]))
		{
			self::$_js_route[$path] = array();
		}

		foreach ($uris as $uri)
		{
			$uri_regex = Route::compile($uri, $regex);

			self::$_js_route[$path][] = $uri_regex;
		}
	}

}

