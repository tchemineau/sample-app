define([
	'marionette',
	'router',
	'module/account/router',
	'view/appLayout'
], function (Marionette, appRouter, AccountRouter, appLayout)
{
	"use strict";

	var app = new Marionette.Application();

	// This will store the user information
	app.user = null;

	// This will store the user token
	app.token = null;

	// This will store the application url
	app.url = '/';

	// Add the main region
	app.addRegions({
		root: '#approot'
	});

	// Catch page error event
	app.vent.on('page:error', function()
	{
		require(['view/errorView'], function(ErrorView)
		{
			var errorView = new ErrorView({app: app});
			app.root.currentView.page.show(errorView);
		});
	});

	// Catch page login event
	app.vent.on('page:login', function()
	{
		require(['view/loginView'], function(LoginView)
		{
			app.root.currentView.page.show(new LoginView({app: app}));
		});
	});

	// Catch page logout event
	app.vent.on('page:logout', function()
	{
		app.vent.trigger('logout:success');
	});

	// Catch welcome page event
	app.vent.on('page:welcome', function()
	{
		require(['view/welcomeView'], function(WelcomeView)
		{
			app.root.currentView.page.show(new WelcomeView({app: app}));
		});
	});

	// Launch application once all is loaded
	app.addInitializer(function(options)
	{
		options.app = app;

		this.layout = new appLayout(options);
		this.router = new appRouter(options);
		this.accountRouter = new AccountRouter(options);

		app.root.show(this.layout);
		app.vent.trigger('page:welcome');
	});

	return app;
});

