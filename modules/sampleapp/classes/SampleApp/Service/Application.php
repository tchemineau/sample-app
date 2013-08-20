<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Application service class
 */
class SampleApp_Service_Application extends Service
{

	/**
	 * Internal JS module to load at initialization
	 */
	private static $_js_init = array();

	/**
	 * Internal JS routes
	 */
	private static $_js_uris = array();

	/**
	 * Return JS module to load a initialization
	 *
	 * @return {array}
	 */
	public static function get_js_init ()
	{
		return self::$_js_init;
	}

	/**
	 * Return JS module depending of a given route
	 *
	 * @param {string} $uri An URI
	 */
	public static function get_js_path ( $uri )
	{
		$matches = array();

		foreach (self::$_js_uris as $path => $uris_regex)
		{
			foreach ($uris_regex as $uri_regex)
			{
				if (preg_match($uri_regex, $uri))
					$matches[] = $path;
			}
		}

		return $matches;
	}

	/**
	 * Register a JS module to be load at initialization
	 *
	 * @param {string} $path Path of the JS module to load
	 */
	public static function set_js_init ( $path )
	{
		self::$_js_init[] = $path;
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
		if (!isset(self::$_js_uris[$path]))
		{
			self::$_js_uris[$path] = array();
		}

		foreach ($uris as $uri)
		{
			$uri_regex = Route::compile($uri, $regex);

			self::$_js_uris[$path][] = $uri_regex;
		}
	}

} // End SampleApp_Service_Application

