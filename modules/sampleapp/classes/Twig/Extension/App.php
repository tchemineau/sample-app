<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Simple extension for Twig, to use mechanisms of Kohana.
 */
class Twig_Extension_App extends Twig_Extension
{

	public function getFunctions()
	{
		return array(
			// I18n function
			new Twig_SimpleFunction('__', function( $string, $values = NULL )
			{
				return Service::factory('I18n')->get_string($string, $values);
			}),
		);
	}

	public function getName()
	{
		return 'Sample App Twig Extension';
	}

}

