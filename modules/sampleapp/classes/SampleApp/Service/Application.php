<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Application service class
 */
class SampleApp_Service_Application extends Service
{

	/**
	 * CSS script to load
	 */
	private static $_css_script = array();

	/**
	 * Internal JS module to load at initialization
	 */
	private static $_js_init = array();

	/**
	 * JS script to load
	 */
	private static $_js_script = array();

	/**
	 * Internal JS routes
	 */
	private static $_js_uris = array();

	/**
	 * Return CSS script to load
	 *
	 * @return {array}
	 */
	public static function get_css_script ()
	{
		return self::$_css_script;
	}

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
	 * Return JS script to load
	 *
	 * @return {array}
	 */
	public static function get_js_script ()
	{
		return self::$_js_script;
	}

	/**
	 * Register a CSS script to be loaded
	 *
	 * @param {string} $path
	 */
	public static function set_css_script ( $path )
	{
		self::$_css_script[] = $path;
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
	public static function set_js_path ( $path, array $uris, array $regex = NULL )
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

	/**
	 * Register a JS script to be loaded
	 *
	 * @param {string} $path
	 */
	public static function set_js_script ( $path, $data = array() )
	{
		self::$_js_script[] = array(
			'src' => $path,
			'data' => $data
		);
	}

} // End SampleApp_Service_Application

