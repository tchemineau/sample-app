
define([
	'marionette',
	'text!template/appMenuView.html'
], function(Marionette, AppMenuTemplate)
{
	var AppMenuView = Marionette.ItemView.extend(
	{
		template: AppMenuTemplate,

		initialize: function (options)
		{
			var App = options.app;

			App.vent.on('login:success:account', this.refresh, this);
			App.vent.on('logout:success:account', this.refresh, this);
		},

		refresh: function ()
		{
			this.render();
		},

		serializeData: function()
		{
			var App = this.options.app;

			return {
				user: App.user ? App.user.toJSON() : {}
			};
		}
	});

	return AppMenuView;
});

