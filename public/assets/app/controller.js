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
			var App = this.options.app;
			App.vent.trigger('page:error', {request: actions});
		},

		login: function()
		{
			var App = this.options.app;
			App.vent.trigger('page:login');
		},

		logout: function()
		{
			var App = this.options.app;
			App.vent.trigger('page:logout');
		},

		welcome: function()
		{
			var App = this.options.app;
			App.vent.trigger('page:welcome');
		}

	};

	return controller;
});
