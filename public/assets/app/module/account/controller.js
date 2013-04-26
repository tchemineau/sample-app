define([
	'marionette',
	'app'
], function(Marionette, App)
{
	var controller = {

		initialize: function(options)
		{
			this.options = options;
		},

		showAccount: function(path)
		{
			var App = this.options.app;

			require([
				'module/account/model/account',
				'module/account/view/account'
			], function(AccountModel, AccountView)
			{
				var accountModel = new AccountModel();
				accountModel.fetch();

				var accountView = new AccountView({model: accountModel});
				App.root.show(accountView);
			});
		},

	};

	return controller;
});
