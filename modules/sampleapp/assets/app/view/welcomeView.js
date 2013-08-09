
define([
	'marionette',
	'text!template/welcomeView.html'
], function(Marionette, WelcomeTemplate)
{
	var WelcomeView = Marionette.ItemView.extend(
	{
		template: WelcomeTemplate,

		serializeData: function()
		{
			var app = this.options.app;

			return {
				user: app.user ? app.user.toJSON() : {},
				url: app.url
			};
		}
	});

	return WelcomeView;
});
