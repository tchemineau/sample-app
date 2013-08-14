
define([
	'marionette',
	'helper/template',
	'text!template/appMenuView.html'
], function(Marionette, TemplateHelper, appMenuTemplate)
{
	var appMenuView = Marionette.ItemView.extend(
	{
		template: appMenuTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			var app = options.app;

			app.vent.on('account:updated:post', this.render, this);
			app.vent.on('login:success:account', this.render, this);
			app.vent.on('logout:success:account', this.render, this);
		},

		serializeData: function()
		{
			var app = this.options.app;

			return {
				user: app.user ? app.user.toJSON() : {},
				url: app.url
			};
		}
	});

	return appMenuView;
});

