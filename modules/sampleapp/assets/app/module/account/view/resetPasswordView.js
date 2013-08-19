
define([
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!module/account/template/resetPasswordView.html'
], function(Marionette, MarionetteFormView, TemplateHelper, ResetPasswordTemplate)
{
	var passwordUpdated = false;

	var ResetPasswordView = Marionette.FormView.extend(
	{
		template: ResetPasswordTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Declare variables to access template content
		 */
		ui: {
			password: '#account-password',
			password2: '#account-password2'
		},

		/**
		 * Declare inputs
		 */
		fields: {
			password: {
				el: 'password',
				required: "Please enter your password.",
				validations: {
					password: "Please enter a valid Password."
				}
			},
			password2: {
				el: 'password2',
				required: "Please confirm your password.",
				validations: {
					password: "Please enter a valid password.",
					confirmPassword: "The confirmed password doesn't match the password."
				}
			}
		},

		/**
		 * Specific validation rules
		 */
		rules: {
			password: function(val)
			{
				return /^['a-zA-Z0-9]{8,}$/.test(val);
			},
			confirmPassword: function(val)
			{
				return val == this.inputVal('password');
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
				url: 'api/v1/auth/reset_password',
				type: 'POST',
				dataType: 'json',
				data: {
					'token': me.options.token,
					'password': $('#account-password').val()
				},
				success: function (response)
				{
					passwordUpdated = true;
					me.render();
				},
				error: function (xhr, status)
				{
					app.vent.trigger('notify:error', 'Unable to update your password');
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

		serializeData: function()
		{
			var app = this.options.app;

			return {
				passwordUpdated: passwordUpdated,
				url: app.url
			};
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

	return ResetPasswordView;
});

