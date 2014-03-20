define([
	'require',
	'marionette',
	'moment',
	'i18n!nls/i18n.js'
], function (
	lrequire,
	Marionette,
	Moment,
	Translate
){

	/**
	 * strtr() for JavaScript
	 * Translate characters or replace substrings
	 * The above licence and copyright is only applied to this function.
	 *
	 * @author Dmitry Sheiko 
	 * @version strtr.js, v 1.0 
	 * @license MIT
	 * @copyright (c) Dmitry Sheiko http://dsheiko.com
	 * @see https://gist.github.com/dsheiko/2774533
	 */
	String.prototype.strtr = function (replacePairs)
	{
		"use strict";

		var str = this.toString(), key, re;

		for (key in replacePairs)
		{
			if (replacePairs.hasOwnProperty(key))
			{
				re = new RegExp(key, "g");
				str = str.replace(re, replacePairs[key]);
			}
		}

		return str;
	};

	return {

		/**
		 * Function to translate string
		 */
		__: function (string, values)
		{
			// Find the translation string
			if (Translate[string] && typeof Translate[string] !== 'undefined')
				string = Translate[string];

			// Inject values if necessary
			if (typeof values === 'object')
				string = string.strtr(values);

			return string;
		},

		/**
		 * Object to manipulate dates
		 */
		moment: Moment
	};
});
