define([
	'require',
	'marionette'
], function(lrequire, Marionette)
{
	var controller = {

		initialize: function(options)
		{
			this.options = options;
		},

		defaultAction: function(route)
		{
			this.loadModules(route);
		},

		/**
		 * Too complex function :-(
		 * Need to found another way to launch actions after all modules are loaded.
		 */
		loadModules: function(route)
		{
			var app = this.options.app;

			if (typeof route == 'undefined')
				route = 'init';

			$.ajax(
			{
				url: 'api/v1/app/require_js',
				type: 'POST',
				dataType: 'json',
				data: {'route': route},
				async: route != 'init',
				success: function (response)
				{
					var counter = response.data.length;

					// Catch module init event
					app.vent.on('module:init', function()
					{
						counter--;
						if (route == 'init' && counter == 0)
							app.vent.trigger('module:load:post');
					});

					// Load all found modules
					for (var i=0, m=counter; i < m; i++)
					{
						app.vent.trigger('module:load', {
							loadFragment: route != 'init',
							module: response.data[i],
							route: route
						}, true);
					}
				},
				error: function (xhr, status)
				{
					app.vent.trigger('page:error', {route: route});
				}
			});
		},

		login: function()
		{
			var app = this.options.app;
			app.vent.trigger('page:login');
		},

		logout: function()
		{
			var app = this.options.app;
			app.vent.trigger('page:logout');
		},

		welcome: function()
		{
			var app = this.options.app;
			app.vent.trigger('page:welcome');
		}

	};

	return controller;
});
