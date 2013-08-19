<?php defined('SYSPATH') OR die('No direct script access.');

class Twig extends Kohana_Twig
{

	protected static function env()
	{
		// Initialize the environment
		$env = parent::env();

		// Load our custom extension
		$env->addExtension(new Twig_Extension_App());

		// Return the environment as required by the original class
		return $env;
	}

} // End Twig

