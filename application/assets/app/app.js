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

	// Launch routers and application main view
	app.addInitializer(function(options)
	{
		// Add this app to default options for all objects
		options.app = app;

		// Store the url
		app.url = options.url;

		// Initialize the layout
		this.layout = new appLayout(options);

		// Initialize routers
		this.router = new appRouter(options);
		this.accountRouter = new AccountRouter(options);
	});

	// Get session and launch page
	app.addInitializer(function(options)
	{
		// Start the session
		this.router.startSession();

		// Load the application view
		app.root.show(this.layout);

		// Get request from html
		var fragment = $('#app').attr('data-fragment');

		// What to load next ?
		if (fragment && fragment.length > 0)
			this.router.loadFragment(fragment);
		else
			this.router.loadPage('welcome');
	});

	return app;
});

