define([
	'backbone',
	'marionette',
	'module/account/controller',
	'module/account/model/account'
], function(Backbone, Marionette, AccountController, AccountModel)
{
	var AccountRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
			'account/create': 'create',
			'account': 'modify'
		},

		controller: AccountController,

		initialize: function(options)
		{
			var app = options.app;

			this.controller.initialize({
				app: app
			});

			// On login succeed, fetch user and set it into the application
			app.vent.on('login:success', function (data)
			{
				var account = new AccountModel(data);

				account.fetch({
					success: function ()
					{
						app.user = account;
						app.vent.trigger('login:success:account');
						Backbone.history.navigate('');
						app.vent.trigger('page:welcome');
					}
				});
			});

			// On logout succeed, disconnect user
			app.vent.on('logout:success', function ()
			{
				app.user = null;
				app.vent.trigger('logout:success:account');
				Backbone.history.navigate('');
				app.vent.trigger('page:welcome');
			});
		},
	});

	return AccountRouter;
});
