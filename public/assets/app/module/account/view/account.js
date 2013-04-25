
define([
	'marionette',
	'text!module/account/template/account.html'
], function(Marionette, AccountTemplate)
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
			console.log(event);
		}
	});

	return AccountView;
});
