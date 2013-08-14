
define([
	'marionette',
	'helper/template',
	'text!template/errorView.html'
], function(Marionette, TemplateHelper, ErrorTemplate)
{
	var ErrorView = Marionette.ItemView.extend(
	{
		template: ErrorTemplate,
		templateHelpers: TemplateHelper,
	});

	return ErrorView;
});

