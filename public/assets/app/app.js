define([
	'marionette',
	'router'
], function (Marionette, AppRouter)
{
	"use strict";

	var App = new Marionette.Application();

	App.addRegions({
		root: '#approot'
	});

	App.vent.on('page:error', function(options)
	{
		require(['view/error'], function(ErrorView)
		{
			var errorView = new ErrorView(App);
			App.root.show(errorView);
		});
	});

	App.vent.on('page:welcome', function()
	{
		require(['view/welcome'], function(WelcomeView)
		{
			var welcomeView = new WelcomeView(App);
			App.root.show(welcomeView);
		});
	});

	App.addInitializer(function()
	{
		this.router = new AppRouter({
			app: App
		});
	});

	App.addInitializer(function()
	{
		App.vent.trigger('page:welcome');
	});

	return App;
});
