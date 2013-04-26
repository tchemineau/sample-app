
define([
	'marionette',
	'app',
	'text!module/account/template/account.html'
], function(Marionette, App, AccountTemplate)
{
	var AccountView = Marionette.ItemView.extend(
	{
		template: AccountTemplate,

		events: {
			'blur #account-firstname': 'actionSave',
			'blur #account-lastname': 'actionSave',
		},

		ui: {
			firstname: '#account-firstname',
			lastname: '#account-lastname'
		},

		actionSave: function (event)
		{
			App.vent.trigger('account:save', this.model);
		}
	});

	return AccountView;
});
