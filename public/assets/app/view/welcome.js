
define([
	'marionette',
	'text!template/welcome.html'
], function(Marionette, WelcomeTemplate)
{
	var WelcomeView = Marionette.ItemView.extend(
	{
		template: WelcomeTemplate,

		serializeData: function()
		{
			var App = this.options.app;

			return {
				user: App.user ? App.user.toJSON() : {}
			};
		}
	});

	return WelcomeView;
});
