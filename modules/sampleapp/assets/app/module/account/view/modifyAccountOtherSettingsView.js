define([
	'marionette',
	'helper/template',
	'text!module/account/template/modifyAccountOtherSettingsView.html'
], function(
	Marionette,
	TemplateHelper,
	ModifyAccountSettingsViewTemplate
){
	return Marionette.ItemView.extend(
	{
		/**
		 * Catch events
		 */
		events: {
			'click #account-delete-modal-ok': '_onAccountDelete',
		},

		template: ModifyAccountSettingsViewTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Declare variables to access template content
		 */
		ui: {
			deletemodal: '#account-delete-modal'
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
		 * Delete my account
		 */
		_onAccountDelete: function (evt)
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
		}
	});
});
