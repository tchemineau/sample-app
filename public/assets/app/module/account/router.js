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
			var App = options.app;

			this.controller.initialize({
				app: App
			});

			// On login succeed, fetch user and set it into the application
			App.vent.on('login:success', function (data)
			{
				var account = new AccountModel(data);

				account.fetch({
					success: function ()
					{
						App.user = account;
						Backbone.history.navigate('/#');
					}
				});
			});
		},
	});

	return AccountRouter;
});
