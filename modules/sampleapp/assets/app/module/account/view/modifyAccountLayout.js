
define([
	'marionette',
	'helper/template',
	'module/account/view/forgotPasswordFormView',
	'module/account/view/modifyAccountAuthorizationsLayout',
	'module/account/view/modifyAccountProfileFormView',
	'module/account/view/modifyAccountSettingsView',
	'text!module/account/template/modifyAccountLayout.html'
], function(
	Marionette,
	TemplateHelper,
	ForgotPasswordFormView,
	ModifyAccountAuthorizationsLayout,
	ModifyAccountProfileFormView,
	ModifyAccountSettingsView,
	ModifyAccountLayoutTemplate
){
	return Marionette.Layout.extend(
	{
		template: ModifyAccountLayoutTemplate,

		templateHelpers: TemplateHelper,

		events: {
			'click #modify-account-authorizations-tab': '_onDisplayAuthorizations',
			'click #modify-account-password-tab': '_onDisplayPassword',
			'click #modify-account-profile-tab': '_onDisplayProfile',
			'click #modify-account-settings-tab': '_onDisplaySettings'
		},

		regions: {
			authorizations: '#modify-account-authorizations-container',
			password: '#modify-account-password-container',
			profile: '#modify-account-profile-container',
			settings: '#modify-account-settings-container'
		},

		onDomRefresh: function()
		{
			this._onDisplayProfile();
		},

		_onDisplayAuthorizations: function()
		{
			this.authorizations.show(new ModifyAccountAuthorizationsLayout(this.options));
		},

		_onDisplayPassword: function()
		{
			this.password.show(new ForgotPasswordFormView(this.options));
		},

		_onDisplayProfile: function()
		{
			this.profile.show(new ModifyAccountProfileFormView(this.options));
		},

		_onDisplaySettings: function()
		{
			this.settings.show(new ModifyAccountSettingsView(this.options));
		}
	});
});
