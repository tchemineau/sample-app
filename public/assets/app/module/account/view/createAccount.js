
define([
	'marionette',
	'marionette.formview',
	'text!module/account/template/createAccount.html'
], function(Marionette, MarionetteFormView, CreateAccountTemplate)
{
	var CreateAccountView = Marionette.FormView.extend(
	{
		template: CreateAccountTemplate,

		/**
		 * Initialize stuff like event listeners
		 */
		initialize: function ()
		{
			this.listenTo(this.model, 'account:error', this.onModelError);
		},

		/**
		 * Declare variables to access template content
		 */
		ui: {
			email: '#account-email',
			password: '#account-password',
			firstname: '#account-firstname',
			lastname: '#account-lastname'
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
			},
			firstname: {
				el: 'firstname'
			},
			lastname: {
				el: 'lastname'
			},
			password: {
				el: 'password',
				required: "Please enter your password.",
				validations: {
					password: "Please enter a valid Password."
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
			}
		},

		/**
		 * What to do if an error occurs on the model
		 */
		onModelError: function (response, xhr)
		{
			this.showGlobalError(response.message);
		},

		/**
		 * Save model when submit me
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			this.model.set(this.serializeFormData()).savedata();
		},

		/**
		 * What to do if the submit fails
		 */
		onSubmitFail: function (errors)
		{
			this.showLocalErrors(errors);
		},

		/**
		 * Show an error
		 */
		showGlobalError: function (message)
		{
			var container = $('#account-alert-container');
			var alertbox = $('<div class="alert alert-error" />')
				.append($('<button type="button" class="close" data-dismiss="alert">&times;</button>'))
				.append('<strong>Error</strong>: '+message);

			alertbox.appendTo(container).alert();
		},

		/**
		 * Highlight input in error
		 */
		showLocalErrors: function (errors)
		{
			var cpt = 0;

			_(errors).each(function (field)
			{
				$(field.el+'-control').addClass('error');
				$(field.el).tooltip({
					placement: 'right',
					title: field.error[0]}
				);

				if (cpt == 0)
					$(field.el).tooltip('show');

				cpt++;
			});
		}

	});

	return CreateAccountView;
});
