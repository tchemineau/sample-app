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
			'*actions': 'default'
		},

		controller: AppController,

		initialize: function(options)
		{
			var App = options.app;
			var Url = options.url;

			this.controller.initialize({
				app: options.app
			})

			// Catch clicks on every a links
			$(document).on('click', 'a:not([data-bypass])', function (evt)
			{
				var href = $(this).attr('href');
				var protocol = this.protocol + '//';

				if (href.slice(protocol.length) !== protocol)
				{
					evt.preventDefault();
					App.router.navigate(href, {trigger: true});
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
			App.vent.on('login:success', function (data)
			{
				// Store token into the application
				App.token = data.token;

				// Add token to every backbone request
				Backbone.defaultSyncOptions = {headers: {
					'Authorization': data.token
				}};
			});

			// Start history
			Backbone.history.start({
				pushState: false,
				root: Url
			});
		}
	});

	return AppRouter;
});
