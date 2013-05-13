define([
	'require',
	'marionette'
], function(lrequire, Marionette)
{
	var controller = {

		initialize: function (options)
		{
			this.options = options;
		},

		/**
		 * Register new account
		 */
		createAccount: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/createAccount'
			], function(AccountModel, CreateAccountView)
			{
				var accountModel = new AccountModel();
				var createAccountView = new CreateAccountView({app: App, model: accountModel});

				App.vent.on('account:save', function(model)
				{
					accountModel.saveData();
				});

				App.root.show(createAccountView);
			});
		},

		/**
		 * Show account view
		 */
		showAccount: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/account'
			], function(AccountModel, AccountView)
			{
				var accountModel = new AccountModel({app: App});

				accountModel.fetch({
					success: function()
					{
						var accountView = new AccountView({app: App, model: accountModel});

						App.root.show(accountView);
					}
				});
			});
		},

	};

	return controller;
});
