define([
	'marionette'
], function(Marionette)
{
	var controller = {

		initialize: function(options)
		{
			this.options = options;
		},

		default: function(actions)
		{
			var app = this.options.app;
			app.vent.trigger('page:error', {request: actions});
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
