define([
	'require',
	'marionette',
	'i18n!nls/i18n.js'
], function(lrequire, Marionette, Lang)
{

	var helper = {

		__: function (key)
		{
			if (Lang[key] && typeof Lang[key] !== 'undefined')
				return Lang[key];
			return key;
		}

	};

	return helper;

});

