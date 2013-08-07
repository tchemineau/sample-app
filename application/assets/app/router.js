define([
	'marionette',
	'controller'
], function(Marionette, AppController)
{
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

	// This will store the application session
	var session = null;

	// Declare the router
	var AppRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
			'login': 'login',
			'logout': 'logout',
			'': 'welcome',
			'*action': 'defaultAction'
		},

		controller: AppController,

		/**
		 * Initialize this router
		 */
		initialize: function(options)
		{
			// Get the application
			var app = options.app;

			// Get the application url
			var url = options.url;

			// Initialize the controller
			this.controller.initialize(options);

			// Initialize the session
			session = new APP.Session(null, {remote: false});

			// Catch login event
			app.vent.on('login:success', this.login, this);

			// Catch logout event
			app.vent.on('logout:success', this.logout, this);

			// Module load event
			app.vent.on('module:load', this.loadModule, this);

			// Catch clicks on every a links
			$(document).on('click', 'a[href^="/"]:not([data-bypass])', function (evt)
			{
				if (!evt.altKey && !evt.ctrlKey && !evt.metaKey && !evt.shiftKey)
				{
					evt.preventDefault();

					var regexp = new RegExp(url, 'g');
					var href = $(evt.currentTarget).attr('href').replace(regexp, '/').replace(/^\/+/, '/');
					//var href = $(evt.currentTarget).attr('href').replace(regexp, '').replace(/^\//, '');

					app.router.navigate(href, {trigger: true});
				}
			});

			// Start history
			Backbone.history.start({
				pushState: true,
				root: url
			});
		},

		/**
		 * Load fragment
		 */
		loadFragment: function(fragment)
		{
			Backbone.history.loadUrl(fragment);
		},

		/**
		 * Load module
		 */
		loadModule: function(path)
		{
			var self = this;
			var request = path;

			if (typeof request != 'object')
				request = {route: 'unknown', module: request};

			require([request.module], function (Module)
			{
				new Module(self.options);
				self.loadFragment(request.route);
			});
		},

		/**
		 * Load page
		 */
		loadPage: function(page)
		{
			var app = this.options.app;

			app.vent.trigger('page:'+page);
		},

		/**
		 * Login user by storing its token into session
		 */
		login: function (data, navigate)
		{
			// Get the application
			var app = this.options.app;

			// Store token into session
			session.set('auth', true);
			session.set('token', data.token);

			// Add token to every backbone request
			Backbone.defaultSyncOptions = {headers: {
				'Authorization': data.token
			}};

			// Trigger a post success event
			app.vent.trigger('login:success:post', data, navigate);
		},

		/**
		 * Logout the user
		 */
		logout: function (navigate)
		{
			// Get the application
			var app = this.options.app;

			// Delete token into session
			session.logout();

			// Delete token from every backbone request
			Backbone.defaultSyncOptions = {};

			// Trigger a post success event
			app.vent.trigger('logout:success:post', navigate);
		},

		/**
		 * Start session
		 */
		startSession: function ()
		{
			// Get the application
			var app = this.options.app;

			// Get the token from session ?
			var token = session.get('token');

			// If token found, use it and login the user
			if (token)
				app.vent.trigger('login:success', {'token': token}, false);
		}
	});

	return AppRouter;
});
