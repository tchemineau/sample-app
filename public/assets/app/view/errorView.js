
define([
	'marionette',
	'text!template/errorView.html'
], function(Marionette, ErrorTemplate)
{
	var ErrorView = Marionette.ItemView.extend(
	{
		template: ErrorTemplate,
	});

	return ErrorView;
});

