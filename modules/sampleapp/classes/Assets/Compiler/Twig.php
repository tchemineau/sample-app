<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig compiler for assets.
 */
class Assets_Compiler_Twig extends Assets_Compiler
{

	/**
	 * Twig environment
	 */
	protected static $_environment = NULL;

	/**
	 * Compile HTML
	 *
	 * @param {string} $html
	 * @return {string}
	 */
	public function compile ( $html )
	{
		return self::environment()->render($html);
	}

	/**
	 * Return dependencies.
	 * Twig Compiler has not dependencies.
	 *
	 * @param {string} $html
	 * @return NULL
	 */
	public function dependencies ( $html )
	{
		return NULL;
	}

	/**
	 * Create a new Twig environment
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	protected static function env()
	{
		$config = Kohana::$config->load('twig');
		$loader = new Twig_Loader_String();
		return new Twig_Environment($loader, $config->get('environment'));
	}

	/**
	 * Get the Twig environment (or create it on first call)
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	protected static function environment()
	{
		if (static::$_environment === NULL)
			static::$_environment = static::env();

		return static::$_environment;
	}

}

