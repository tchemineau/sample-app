
define([
	'marionette',
	'marionette.formview',
	'text!module/account/template/modifyAccount.html'
], function(Marionette, MarionetteFormView, ModifyAccountTemplate)
{
	var ModifyAccountView = Marionette.FormView.extend(
	{
		template: ModifyAccountTemplate,

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

			var App = this.options.app;

			this.ui.deletemodal.modal('hide');

			this.model.destroy({
				'success': function ()
				{
					App.vent.trigger('logout:success');
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

		/**
		 * Show delete account confirmation
		 */
		showDeleteAccountModal: function (evt)
		{
			this.ui.deletemodal.modal('show');
		}

	});

	return ModifyAccountView;
});
