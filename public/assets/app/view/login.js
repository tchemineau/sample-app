
define([
	'marionette',
	'marionette.formview',
	'text!template/login.html'
], function(Marionette, MarionetteFormView, LoginTemplate)
{
	var LoginView = Marionette.FormView.extend(
	{
		template: LoginTemplate,

		/**
		 * Declare inputs that should be validate
		 */
		fields: {
			email: {
				el: '#login-email',
				required: "Please enter a valid Email Address.",
				validations: {
					email: "Please enter a valid Email Address."
				}
			}
		},

		/**
		 * Submit authentication request
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			var url = 'api/v1/auth';

			var formValues = {
				'email': $('#login-email').val(),
				'password': $('#login-password').val()
			};

			$.ajax(
			{
				url: url,
				type: 'POST',
				dataType: 'json',
				data: formValues,
				success: function (data)
				{
					console.log(['Login request details: ', data]);
					Backbone.history.navigate('/#');
				},
				error: function (xhr, status)
				{
					showGlobalError('Error');
				}
			});
		},

		/**
		 * What to do if the submit fails
		 */
		onSubmitFail: function (errors)
		{
			
		},

		/**
		 * Show an error
		 */
		showGlobalError: function (message)
		{
			var container = $('#login-alert-container');
			var alertbox = $('<div class="alert alert-error" />')
				.append($('<button type="button" class="close" data-dismiss="alert">&times;</button>'))
				.append('<strong>Error</strong>: '+message);

			alertbox.appendTo(container).alert();
		},

	});

	return LoginView;
});
