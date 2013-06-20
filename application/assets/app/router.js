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
			'*actions': 'defaultAction'
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
			session = new APP.Session(null, {
				url: url+'api/v1/auth/session'
			});

			// Catch login event
			app.vent.on('login:success', this.login, this);

			// Catch logout event
			app.vent.on('logout:success', this.logout, this);

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
			session.save();

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
