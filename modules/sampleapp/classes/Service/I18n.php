<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A service class to manage internationalization
 */
class Service_I18n extends Service
{

	/**
	 * Get user language
	 *
	 * @return {string}
	 */
	public static function get_language ()
	{
		return Language::getLanguage();
	}

	/**
	 * Returns translation of a string. If no translation exists, the original
	 * string will be returned. No parameters are replaced.
	 *
	 * @param   string  $string    text to translate
	 * @param   string  $values    values to replace
	 * @param   string  $language  target language
	 * @return  string
	 */
	public static function get_string ( $string, $values = NULL, $language = NULL )
	{
		if ( ! $language)
			$language = self::get_language();

		$string = I18n::get($string, $language);

		return empty($values) ? $string : strtr($string, $values);
	}

	/**
	 * Generate I18n table for a given language
	 *
	 * @param {string} $language
	 */
	public static function get_table ( $language = NULL )
	{
		if (! $language)
			$language = self::get_language();

		return I18n::load($language);
	}

}

