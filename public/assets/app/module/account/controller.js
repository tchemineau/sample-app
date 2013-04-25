define([
	'marionette'
], function(Marionette)
{
	var controller = {

		initialize: function(options)
		{
			this.options = options;
		},

		showAccount: function(path)
		{
			var opt = this.options;
			var App = this.options.app;

			require(['module/account/view/account'], function(AccountView)
			{
				var accountView = new AccountView(App);
				App.root.show(accountView);
			});
		},

	};

	return controller;
});
