
define([
	'marionette',
	'helper/template',
	'text!module/account/template/modifyAccountSettingsView.html'
], function(Marionette, TemplateHelper, ModifyAccountSettingsViewTemplate)
{
	var modifyAccountSettingsView = Marionette.ItemView.extend(
	{
		template: ModifyAccountSettingsViewTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Declare variables to access template content
		 */
		ui: {
			deletemodal: '#account-delete-modal'
		},

		/**
		 * Catch events
		 */
		events: {
			'click #account-delete-btn': 'showDeleteAccountModal',
			'click #account-delete-modal-ok': 'onAccountDelete',
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
		 * Serialize data for template
		 */
		serializeData: function ()
		{
			var app = this.options.app;

			return $.extend({}, this.model.toJSON(), {
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

	return modifyAccountSettingsView;
});

