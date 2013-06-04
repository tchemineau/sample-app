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
		create: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/createAccount'
			], function(AccountModel, CreateAccountView)
			{
				var createAccountView = new CreateAccountView({
					app: App,
					model: new AccountModel()
				});

				App.root.currentView.page.show(createAccountView);
			});
		},

		/**
		 * Show account view
		 */
		modify: function ()
		{
			var App = this.options.app;

			lrequire([
				'./model/account',
				'./view/modifyAccount'
			], function (AccountModel, ModifyAccountView)
			{
				var data = {};

				if (App.user)
					data.id = App.user.id;

				var account = new AccountModel(data);

				account.fetch({
					success: function ()
					{
						var modifyAccountView = new ModifyAccountView({app: App, model: account});

						App.root.currentView.page.show(modifyAccountView);
					}
				});
			});
		}

	};

	return controller;
});
