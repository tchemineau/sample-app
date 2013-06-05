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
			var app = this.options.app;

			lrequire([
				'./model/account',
				'./view/createAccountView'
			], function(AccountModel, CreateAccountView)
			{
				var createAccountView = new CreateAccountView({
					app: app,
					model: new AccountModel()
				});

				app.root.currentView.page.show(createAccountView);
			});
		},

		/**
		 * Show account view
		 */
		modify: function ()
		{
			var app = this.options.app;

			lrequire([
				'./model/account',
				'./view/modifyAccountView'
			], function (AccountModel, ModifyAccountView)
			{
				var data = {};

				if (app.user)
					data.id = app.user.id;

				var account = new AccountModel(data);

				account.fetch({
					success: function ()
					{
						var modifyAccountView = new ModifyAccountView({app: app, model: account});

						app.root.currentView.page.show(modifyAccountView);
					}
				});
			});
		}

	};

	return controller;
});
