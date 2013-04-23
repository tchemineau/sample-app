define([
	'marionette'
], function(Marionette)
{
	var controller = {

		initialize: function(options)
		{
			this.options = options;
		},

		account: function()
		{
			var opt = this.options;
			var App = this.options.app;

			require(['module/account/controller'], function(AccountController)
			{
				var accountController = new AccountController(opt);
				accountController.trigger('page:account');
			});
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
