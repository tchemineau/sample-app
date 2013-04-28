define([
	'marionette',
	'module/account/controller'
], function(Marionette, AccountController)
{
	var AccountRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
			'!/account/create': 'createAccount',
			'!/account': 'showAccount'
		},

		controller: AccountController,

		initialize: function(options)
		{
			this.controller.initialize({
				app: options.app
			})
		}
	});

	return AccountRouter;
});
