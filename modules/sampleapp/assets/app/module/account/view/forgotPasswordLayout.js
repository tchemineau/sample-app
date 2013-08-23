
define([
	'marionette',
	'helper/template',
	'module/account/view/forgotPasswordFormView',
	'text!module/account/template/forgotPasswordLayout.html'
], function(Marionette, TemplateHelper, ForgotPasswordFormView, ForgotPasswordTemplate)
{
	var forgotPasswordLayout = Marionette.Layout.extend(
	{
		template: ForgotPasswordTemplate,

		templateHelpers: TemplateHelper,

		regions: {
			form: '#forgot-password-container'
		},

		onDomRefresh: function()
		{
			this.form.show(new ForgotPasswordFormView(this.options));
		}
	});

	return forgotPasswordLayout;
});

