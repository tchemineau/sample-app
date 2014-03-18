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
			'login': 'doLogin',
			'logout': 'doLogout',
			'': 'doWelcome',
			'*action': 'doDefault'
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

			// Initialize module list
			this.modules = {};

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

					app.router.navigate(href, {trigger: true});
					app.router._track();
				}
			});

			// Load modules
			this.controller.loadModules();

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
			// This is me
			var me = this;

			// Default request
			var request = {
				'loadFragment': false,
				'request': null,
				'route': 'unknow'
			};

			// Build coming request
			if (typeof path == 'object')
				request = path;
			else
				request = $.extend({}, request, {module: request});

			// If module, load it
			if (request.module)
			{
				require([request.module], function (Module)
				{
					if (typeof me.modules[request.module] === 'undefined')
						me.modules[request.module] = new Module(me.options);

					if (request.loadFragment)
						me.loadFragment(request.route);
				});
			}
		},

		/**
		 * Load page
		 */
		loadPage: function(page)
		{
			var action = 'do' + page.charAt(0).toUpperCase() + page.slice(1);

			if (typeof this.controller[action] !== 'undefined')
				this.controller[action]();
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
			// Initialize the session
			session = new APP.Session(null, {
				persist: true,
				remote: false
			});

			// Get the application
			var app = this.options.app;

			// Get the token from session ?
			var token = session.get('token');

			// If token found, use it and login the user
			if (token)
				app.vent.trigger('login:success', {'token': token}, false);
		},

		/**
		 * Track URL changes
		 */
		_track: function ()
		{
			var url = Backbone.history.root + Backbone.history.getFragment();

			if( typeof ga === 'function' ) ga('send', 'pageview', {'page': url});
		}
	});

	return AppRouter;
});
