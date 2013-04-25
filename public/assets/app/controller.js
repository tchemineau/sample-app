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

		welcome: function()
		{
			var App = this.options.app;
			App.vent.trigger('page:welcome');
		}

	};

	return controller;
});
