define([
	'marionette',
	'controller'
], function(Marionette, AppController)
{
	var AppRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
			'login': 'login',
			'logout': 'logout',
			'': 'welcome',
			'*actions': 'defaultAction'
		},

		controller: AppController,

		loadFragment: function(fragment)
		{
			Backbone.history.loadUrl(fragment);
		},

		loadPage: function(page)
		{
			var app = this.options.app;

			app.vent.trigger('page:'+page);
		},

		initialize: function(options)
		{
			var app = options.app;
			var url = options.url;

			// Store the url
			app.url = url;

			// Initialize the controller
			this.controller.initialize(options);

			// Catch clicks on every a links
			$(document).on('click', 'a[href^="/"]:not([data-bypass])', function (evt)
			{
				if (!evt.altKey && !evt.ctrlKey && !evt.metaKey && !evt.shiftKey)
				{
					evt.preventDefault();

					var regexp = new RegExp(url, 'g');
					var href = $(evt.currentTarget).attr('href').replace(regexp, '').replace(/^\//, '');

					app.router.navigate(href, {trigger: true});
				}
			});

			// Store the native, default sync method
			Backbone._nativeSync = Backbone.sync;

			// Create our default options object
			Backbone.defaultSyncOptions = {};

			// Ever so gingerly wrap the native sync
			// in a method that combines options
			Backbone.sync = function (method, model, options)
			{
				Backbone._nativeSync(method, model,
					_.extend({}, Backbone.defaultSyncOptions, options)
				);
			};

			// Catch login event
			app.vent.on('login:success', function (data)
			{
				// Store token into the application
				app.token = data.token;

				// Add token to every backbone request
				Backbone.defaultSyncOptions = {headers: {
					'Authorization': data.token
				}};
			});

			// Catch logout event
			app.vent.on('logout:success', function ()
			{
				// Delete token
				app.token = null;

				// Delete token from every backbone request
				Backbone.defaultSyncOptions = {};
			});

			// Start history
			Backbone.history.start({
				pushState: true,
				root: url
			});
		}
	});

	return AppRouter;
});
