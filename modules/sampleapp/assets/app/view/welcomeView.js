
define([
	'marionette',
	'helper/template',
	'text!template/welcomeView.html'
], function(Marionette, TemplateHelper, WelcomeTemplate)
{
	var WelcomeView = Marionette.ItemView.extend(
	{
		template: WelcomeTemplate,

		templateHelpers: TemplateHelper,

		serializeData: function()
		{
			var app = this.options.app;

			return {
				title: app.title,
				user: app.user ? app.user.toJSON() : {},
				url: app.url
			};
		}
	});

	return WelcomeView;
});
