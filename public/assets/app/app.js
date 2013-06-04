define([
	'marionette',
	'router',
	'module/account/router',
	'view/appLayout'
], function (Marionette, AppRouter, AccountRouter, AppLayout)
{
	"use strict";

	var App = new Marionette.Application();

	// This will store the user information
	App.user = null;

	// This will store the user token
	App.token = null;

	// Add the main region
	App.addRegions({
		root: '#approot'
	});

	// Catch page error event
	App.vent.on('page:error', function()
	{
		require(['view/error'], function(ErrorView)
		{
			var errorView = new ErrorView({app: App});
			App.root.currentView.page.show(errorView);
		});
	});

	// Catch page login event
	App.vent.on('page:login', function()
	{
		require(['view/login'], function(LoginView)
		{
			App.root.currentView.page.show(new LoginView({app: App}));
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
			App.root.currentView.page.show(new WelcomeView({app: App}));
		});
	});

	// Launch application once all is loaded
	App.addInitializer(function(options)
	{
		options.app = App;

		this.layout = new AppLayout(options);
		this.router = new AppRouter(options);
		this.accountRouter = new AccountRouter(options);

		App.root.show(this.layout);
		App.vent.trigger('page:welcome');
	});

	return App;
});
