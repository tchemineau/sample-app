define([
	'marionette',
	'router',
	'module/account/router',
], function (Marionette, AppRouter, AccountRouter)
{
	"use strict";

	var App = new Marionette.Application();

	// Add the main region
	App.addRegions({
		root: '#approot'
	});

	// This will store the user information
	App.user = null;

	// This will store the user token
	App.token = null;

	// Catch page error event
	App.vent.on('page:error', function()
	{
		require(['view/error'], function(ErrorView)
		{
			var errorView = new ErrorView({app: App});
			App.root.show(errorView);
		});
	});

	// Catch page login event
	App.vent.on('page:login', function()
	{
		require(['view/login'], function(LoginView)
		{
			App.root.show(new LoginView({app: App}));
		});
	});

	// Catch page logout event
	App.vent.on('page:logout', function()
	{
		App.vent.trigger('logout:success');
	});

	// Catch welcome page event
	App.vent.on('page:welcome', function()
	{
		require(['view/welcome'], function(WelcomeView)
		{
			App.root.show(new WelcomeView({app: App}));
		});
	});

	// Launch application once all is loaded
	App.addInitializer(function(options)
	{
		options.app = App;

		this.router = new AppRouter(options);
		this.accountRouter = new AccountRouter(options);

		App.vent.trigger('page:welcome');
	});

	return App;
});
