define([
	'marionette',
	'router',
	'view/appLayout'
], function (Marionette, appRouter, appLayout)
{
	"use strict";

	var app = new Marionette.Application();

	// This will store the application url
	app.url = '/';

	// This will store the user information
	app.user = null;

	// Add the main region
	app.addRegions({
		root: '#approot'
	});

	// Catch account updates
	app.vent.on('account:updated', function (account)
	{
		app.user = account;
		app.vent.trigger('account:updated:success');
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

		// Initialize the main router
		this.router = new appRouter(options);
	});

	// Get session and launch page
	app.on('start', function(options)
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

