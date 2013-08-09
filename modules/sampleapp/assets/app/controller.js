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
			var app = this.options.app;

			// Check for an existing dynamic modules
			$.ajax(
			{
				url: 'api/v1/app/require_js',
				type: 'POST',
				dataType: 'json',
				data: {
					'route': route,
				},
				success: function (response)
				{
					app.vent.trigger('module:load', {route: route, module: response.data.path}, true);
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
