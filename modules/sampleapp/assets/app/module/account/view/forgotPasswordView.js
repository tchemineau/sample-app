
define([
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!module/account/template/forgotPasswordView.html'
], function(Marionette, MarionetteFormView, TemplateHelper, ForgotPasswordTemplate)
{
	var passwordSent = false;

	var ForgotPasswordView = Marionette.FormView.extend(
	{
		template: ForgotPasswordTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Declare variables to access template content
		 */
		ui: {
			email: '#account-email'
		},

		/**
		 * Declare inputs
		 */
		fields: {
			email: {
				el: 'email',
				required: "Please enter a valid Email Address.",
				validations: {
					email: "Please enter a valid Email Address."
				}
			}
		},

		/**
		 * Save model when submit me
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			// This store this object
			var me = this;

			// Get application
			var app = this.options.app;

			// Do the request to log the user
			$.ajax(
			{
				url: 'api/v1/auth/forgot_password',
				type: 'POST',
				dataType: 'json',
				data: {
					'email': $('#account-email').val()
				},
				success: function (response)
				{
					passwordSent = true;
					me.render();
				},
				error: function (xhr, status)
				{
					app.vent.trigger('notify:error', 'Unable to send reset password instructions');
				}
			});
		},

		/**
		 * What to do if the submit fails
		 */
		onSubmitFail: function (errors)
		{
			this.showLocalErrors(errors);
		},

		serializeData: function ()
		{
			return {passwordSent: passwordSent};
		},

		/**
		 * Highlight input in error
		 */
		showLocalErrors: function (errors)
		{
			var cpt = 0;

			_(errors).each(function (field)
			{
				$('#account-'+field.el+'-control').addClass('error');
				$('#account-'+field.el).tooltip({
					placement: 'right',
					title: field.error[0]}
				);

				if (cpt == 0)
					$('#account-'+field.el).tooltip('show');

				cpt++;
			});
		}

	});

	return ForgotPasswordView;
});

