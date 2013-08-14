
define([
	'backbone',
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!template/loginView.html'
], function(Backbone, Marionette, MarionetteFormView, TemplateHelper, LoginTemplate)
{
	var LoginView = Marionette.FormView.extend(
	{
		template: LoginTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			var app = options.app;

			if (app.user)
			{
				Backbone.history.navigate('');
				app.router.loadPage('welcome');
			}
		},

		/**
		 * Submit authentication request
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
				url: 'api/v1/auth',
				type: 'POST',
				dataType: 'json',
				data: {
					'email': $('#login-email').val(),
					'password': $('#login-password').val()
				},
				success: function (response)
				{
					app.vent.trigger('login:success', response.data, true);
				},
				error: function (xhr, status)
				{
					me.showGlobalError('Unable to authenticate');
				}
			});
		},

		serializeData: function()
		{
			var app = this.options.app;

			return {
				user: app.user ? app.user.toJSON() : {},
				url: app.url
			};
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
		}

	});

	return LoginView;
});
