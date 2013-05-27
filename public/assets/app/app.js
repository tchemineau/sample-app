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

	App.vent.on('page:login', function()
	{
		require(['view/login'], function(LoginView)
		{
			App.root.show(new LoginView({app: App}));
		});
	});

	App.vent.on('page:logout', function()
	{
		console.log('Do logout process');
	});

	App.vent.on('page:welcome', function()
	{
		require(['view/welcome'], function(WelcomeView)
		{
			App.root.show(new WelcomeView({app: App}));
		});
	});

	App.addInitializer(function(options)
	{
		options.app = App;

		this.router = new AppRouter(options);
		this.accountRouter = new AccountRouter(options);

		App.vent.trigger('page:welcome');
	});

	return App;
});
