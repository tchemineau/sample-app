define([
	'marionette',
	'app'
], function(Marionette, App)
{
	var AccountController = Marionette.Controller.extend({

		initialize: function(options)
		{
			this.options = options;

			this.on('page:account', function(){ this.showIndex(); });
		},

		showIndex: function()
		{
			var App = this.options.app;

			require(['module/account/view/account'], function(AccountView)
			{
				var accountView = new AccountView(App);
				App.root.show(accountView);
			});
		},

	});

	return AccountController;
});
