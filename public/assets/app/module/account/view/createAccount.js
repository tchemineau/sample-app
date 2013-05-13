
define([
	'marionette',
	'text!module/account/template/createAccount.html'
], function(Marionette, CreateAccountTemplate)
{
	var CreateAccountView = Marionette.ItemView.extend(
	{
		template: CreateAccountTemplate,

		events: {
			'click #account-create-btn': 'actionCreate'
		},

		ui: {
			email: '#account-email',
			password: '#account-password',
			firstname: '#account-firstname',
			lastname: '#account-lastname'
		},

		actionCreate: function (event)
		{
			var App = this.options.app;

			event.preventDefault();
			event.stopPropagation();

			this.model.set({
				'email': this.ui.email.val(),
				'password': this.ui.password.val(),
				'firstname': this.ui.firstname.val(),
				'lastname': this.ui.lastname.val()
			});

			App.vent.trigger('account:save', this.model);
		}
	});

	return CreateAccountView;
});
