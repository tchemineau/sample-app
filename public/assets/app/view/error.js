
define([
	'marionette',
	'text!template/error.html'
], function(Marionette, ErrorTemplate)
{
	var ErrorView = Marionette.ItemView.extend(
	{
		template: ErrorTemplate,
	});

	return ErrorView;
});

