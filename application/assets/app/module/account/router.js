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
			// Store options
			this.options = options;

			// Get the application
			var app = options.app;

			// Initialize the controller
			this.controller.initialize({app: app});

			// On login post succeed, fetch user and set it into the application
			app.vent.on('login:success:post', this.login, this);

			// On logout succeed, disconnect user
			app.vent.on('logout:success:post', this.logout, this);
		},

		/**
		 * Do things to login the user
		 */
		login: function (data, navigate)
		{
			// Get the application
			var app = this.options.app;

			// If navigate is not define, it's true
			if (typeof navigate !== 'boolean')
				navigate = true;

			// Load the user account from given data (which contains id)
			var account = new AccountModel(data);
			account.fetch({
				success: function ()
				{
					// Store user account
					app.user = account;

					// Launch a event to notify that login has succeed
					app.vent.trigger('login:success:account');

					// Navigate if necessary
					if (navigate)
					{
						Backbone.history.navigate('');
						app.router.loadPage('welcome');
					}
				}
			});
		},

		/**
		 * Do things to logout the user
		 */
		logout: function (navigate)
		{
			// Get the application
			var app = this.options.app;

			// If navigate is not define, it's true
			if (typeof navigate !== 'boolean')
				navigate = true;

			// Destroy user
			app.user = null;

			// Notify that logout has succeed
			app.vent.trigger('logout:success:account');

			// Navigate if necessary
			if (navigate)
			{
				Backbone.history.navigate('');
				app.router.loadPage('welcome');
			}
		}

	});

	return AccountRouter;
});
