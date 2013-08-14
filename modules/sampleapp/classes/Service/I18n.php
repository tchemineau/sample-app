<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A service class to manage internationalization
 */
class Service_I18n extends Service
{

	/**
	 * Generate I18n table for a given language
	 *
	 * @param {string} $language
	 */
	public static function get_table ( $language )
	{
		return I18n::load($language);
	}

}

