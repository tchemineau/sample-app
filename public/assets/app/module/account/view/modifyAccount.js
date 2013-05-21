
define([
	'marionette',
	'app',
	'text!module/account/template/modifyAccount.html'
], function(Marionette, App, ModifyAccountTemplate)
{
	var ModifyAccountView = Marionette.ItemView.extend(
	{
		template: ModifyAccountTemplate,

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

	return ModifyAccountView;
});
