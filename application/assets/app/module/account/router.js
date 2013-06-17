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
			'account': 'modify',
			'account/confirm/:token': 'confirm',
			'account/create': 'create',
			'account/forgot_password': 'forgotPassword',
			'account/reset_password/:token': 'resetPassword'
		},

		controller: AccountController,

		initialize: function(options)
		{
			// Get the application
			var app = options.app;

			// Initialize the controller
			this.controller.initialize({app: app});

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
						app.router.loadPage('welcome');
					}
				});
			});

			// On logout succeed, disconnect user
			app.vent.on('logout:success', function ()
			{
				app.user = null;
				app.vent.trigger('logout:success:account');

				Backbone.history.navigate('');
				app.router.loadPage('welcome');
			});
		},
	});

	return AccountRouter;
});
