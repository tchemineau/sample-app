
define([
	'marionette',
	'helper/template',
	'module/account/view/forgotPasswordFormView',
	'module/account/view/modifyAccountProfilFormView',
	'module/account/view/modifyAccountSettingsView',
	'text!module/account/template/modifyAccountLayout.html'
], function(Marionette, TemplateHelper, ForgotPasswordFormView, ModifyAccountProfilFormView, ModifyAccountSettingsView, ModifyAccountLayoutTemplate)
{
	var modifyAccountLayout = Marionette.Layout.extend(
	{
		template: ModifyAccountLayoutTemplate,

		templateHelpers: TemplateHelper,

		regions: {
			password: '#modify-account-password-container',
			profil: '#modify-account-profil-container',
			settings: '#modify-account-settings-container'
		},

		onDomRefresh: function()
		{
			this.password.show(new ForgotPasswordFormView(this.options));
			this.profil.show(new ModifyAccountProfilFormView(this.options));
			this.settings.show(new ModifyAccountSettingsView(this.options));
		}
	});

	return modifyAccountLayout;
});
