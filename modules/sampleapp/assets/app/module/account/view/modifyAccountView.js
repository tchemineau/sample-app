
define([
	'marionette',
	'marionette.formview',
	'text!module/account/template/modifyAccountView.html'
], function(Marionette, MarionetteFormView, ModifyAccountTemplate)
{
	var accountModified = false;

	var ModifyAccountView = Marionette.FormView.extend(
	{
		template: ModifyAccountTemplate,

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
			'click #account-delete-modal-ok': 'onAccountDelete'
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
					app.vent.trigger('page:logout');
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

			this.render();
		},

		onRender: function ()
		{
			window.setTimeout(function()
			{
				accountModified = false;
				$(".alert-success").alert('close');
			}, 5000);
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
