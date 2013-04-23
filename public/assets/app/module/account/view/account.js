
define([
	'marionette',
	'text!module/account/template/account.html'
], function(Marionette, AccountTemplate)
{
	var AccountView = Marionette.ItemView.extend(
	{
		template: AccountTemplate,
	});

	return AccountView;
});
