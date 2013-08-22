
define([
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!module/account/template/modifyAccountView.html'
], function(Marionette, MarionetteFormView, TemplateHelper, ModifyAccountTemplate)
{
	var accountModified = false;

	var ModifyAccountView = Marionette.FormView.extend(
	{
		template: ModifyAccountTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			this.listenTo(this.model, 'account:save:success', this.onAccountSave);
		},

		/**
		 * Declare variables to access template content
		 */
		ui: {
			firstname: '#account-firstname',
			lastname: '#account-lastname',
			deletemodal: '#account-delete-modal'
		},

		/**
		 * Catch events
		 */
		events: {
			'click #account-delete-btn': 'showDeleteAccountModal',
			'click #account-delete-modal-ok': 'onAccountDelete',
			'click #account-password-btn': 'onPasswordReset'
		},

		/**
		 * Declare inputs
		 */
		fields: {
			firstname: {
				el: 'firstname'
			},
			gravatar_email: {
				el: 'gravatar_email'
			},
			lastname: {
				el: 'lastname'
			}
		},

		/**
		 * Delete my account
		 */
		onAccountDelete: function (evt)
		{
			evt.preventDefault();

			var app = this.options.app;

			this.ui.deletemodal.modal('hide');

			this.model.destroy({
				'success': function ()
				{
					app.vent.trigger('logout:success');
				}
			});
		},

		/**
		 * What to do when account information has been save
		 */
		onAccountSave: function ()
		{
			var app = this.options.app;

			accountModified = true;

			app.vent.trigger('account:updated', this.model);
			app.vent.trigger('notify:success', TemplateHelper.__('Information saved'));

			this.render();
		},

		/**
		 * Reset my password
		 */
		onPasswordReset: function (evt)
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
					'email': app.user.get('email')
				},
				success: function (response)
				{
					app.vent.trigger('notify:success', 'Reset password instructions has been sent');
				},
				error: function (xhr, status)
				{
					app.vent.trigger('notify:error', 'Unable to send reset password instructions');
				}
			});
		},

		/**
		 * Save model when submit me
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			this.model.set(this.serializeFormData()).savedata();
		},

		serializeData: function ()
		{
			var app = this.options.app;

			return $.extend({}, this.model.toJSON(), {
				accountModified: accountModified,
				url: app.url
			});
		},

		/**
		 * Show delete account confirmation
		 */
		showDeleteAccountModal: function (evt)
		{
			evt.preventDefault();

			this.ui.deletemodal.modal('show');
		}

	});

	return ModifyAccountView;
});
