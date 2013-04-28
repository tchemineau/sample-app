
define([
	'marionette',
	'text!module/account/template/createAccount.html'
], function(Marionette, CreateAccountTemplate)
{
	var CreateAccountView = Marionette.ItemView.extend(
	{
		template: CreateAccountTemplate,

		events: {
			'click #account-create': 'actionCreate'
		},

		ui: {
			email: '#account-email',
			password: '#account-password',
			firstname: '#account-firstname',
			lastname: '#account-lastname'
		},

		actionCreate: function (event)
		{
			App.vent.trigger('account:create', this.model);
		}
	});

	return CreateAccountView;
});
