
define([
	'marionette',
	'helper/template',
	'module/account/view/forgotPasswordFormView',
	'module/account/view/modifyAccountAuthorizationsLayout',
	'module/account/view/modifyAccountOtherSettingsView',
	'module/account/view/modifyAccountProfileFormView',
	'text!module/account/template/modifyAccountLayout.html'
], function(
	Marionette,
	TemplateHelper,
	ForgotPasswordFormView,
	ModifyAccountAuthorizationsLayout,
	ModifyAccountOtherSettingsView,
	ModifyAccountProfileFormView,
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
			'click #modify-account-settings-tab': '_onDisplayOtherSettings'
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

		_onDisplayOtherSettings: function()
		{
			this.settings.show(new ModifyAccountOtherSettingsView(this.options));
		}
	});
});
