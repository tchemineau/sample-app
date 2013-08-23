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
		 * Confirm a new account
		 */
		confirm: function (token)
		{
			var app = this.options.app;

			lrequire([
				'./view/confirmAccountView'
			], function(ConfirmAccountView)
			{
				var confirmAccountView = new ConfirmAccountView({
					app: app,
					token: token
				});

				app.root.currentView.page.show(confirmAccountView);
			});
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
		 * Show a password reset form
		 */
		forgotPassword: function ()
		{
			var app = this.options.app;

			lrequire([
				'./view/forgotPasswordLayout'
			], function (ForgotPasswordLayout)
			{
				var forgotPasswordLayout = new ForgotPasswordLayout({app: app});

				app.root.currentView.page.show(forgotPasswordLayout);
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
				'./view/modifyAccountLayout'
			], function (AccountModel, ModifyAccountLayout)
			{
				var data = {};

				if (app.user)
					data.id = app.user.id;

				var account = new AccountModel(data);

				account.fetch({
					error: function()
					{
						app.vent.trigger('page:error');
					},
					success: function()
					{
						var modifyAccountLayout = new ModifyAccountLayout({app: app, model: account});

						app.root.currentView.page.show(modifyAccountLayout);
					}
				});
			});
		},

		/**
		 * Show a reset password form
		 */
		resetPassword: function (token)
		{
			var app = this.options.app;

			lrequire([
				'./view/resetPasswordView'
			], function(ResetPasswordView)
			{
				var resetPasswordView = new ResetPasswordView({
					app: app,
					token: token
				});

				app.root.currentView.page.show(resetPasswordView);
			});
		}

	};

	return controller;
});
