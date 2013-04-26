define([
	'marionette',
	'router',
	'module/account/router',
], function (Marionette, AppRouter, AccountRouter)
{
	"use strict";

	var App = new Marionette.Application();

	App.addRegions({
		root: '#approot'
	});

	App.vent.on('page:error', function()
	{
		require(['view/error'], function(ErrorView)
		{
			var errorView = new ErrorView({app: App});
			App.root.show(errorView);
		});
	});

	App.vent.on('page:welcome', function(options)
	{
		require(['view/welcome'], function(WelcomeView)
		{
			var welcomeView = new WelcomeView({app: App});
			App.root.show(welcomeView);
		});
	});

	App.addInitializer(function(options)
	{
		options.app = App;

		this.router = new AppRouter(options);
		this.accountRouter = new AccountRouter(options);
	});

	App.addInitializer(function(options)
	{
		App.vent.trigger('page:welcome');
	});

	return App;
});
