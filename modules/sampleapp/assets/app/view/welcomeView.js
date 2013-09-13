
define([
	'marionette',
	'stellar',
	'helper/template',
	'text!template/welcomeView.html'
], function(Marionette, Stellar, TemplateHelper, WelcomeTemplate)
{
	var WelcomeView = Marionette.ItemView.extend(
	{
		template: WelcomeTemplate,

		templateHelpers: TemplateHelper,

		onDomRefresh: function ()
		{
			$.stellar();
		},

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
