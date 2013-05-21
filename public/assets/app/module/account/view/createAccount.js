
define([
	'marionette',
	'marionette.formview',
	'text!module/account/template/createAccount.html'
], function(Marionette, MarionetteFormView, CreateAccountTemplate)
{
	var CreateAccountView = Marionette.FormView.extend(
	{
		template: CreateAccountTemplate,

                ui: {
                        email: '#account-email',
                        password: '#account-password',
                        firstname: '#account-firstname',
                        lastname: '#account-lastname'
                },

		fields: {
			email: {
				el: '#account-email',
				required: "Please enter a valid Email Address.",
				validations: {
					email: "Please enter a valid Email Address."
				}
			},
			password: {
				el: '#account-password',
				required: "Please enter your password.",
				validations: {
					password: "Please enter a valid Password."
				}
			}
		},

		rules: {
			password: function(val)
			{
				return /^['a-zA-Z0-9]{8,}$/.test(val);
			}
		},

		onSubmit: function (evt)
		{
			evt.preventDefault();

			var data = this.serializeFormData();
			this.model.set(data);

			var App = this.options.app;
			App.vent.trigger('account:save', this.model);
		},

		onSubmitFail: function (errors)
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
		},

		showErrors: function (errors)
		{
			var container = $('#account-alert-container');
			var alertbox = $('<div class="alert alert-error" />')
				.append($('<button type="button" class="close" data-dismiss="alert">&times;</button>'))
				.append('<strong>Error</strong>: Something went wrong');

			alertbox.appendTo(container).alert();
		}
	});

	return CreateAccountView;
});
