define([
	'marionette',
	'helper/template',
	'text!module/account/template/tokenItemView.html'
], function(
	Marionette,
	TemplateHelper,
	TokenItemViewTemplate
){
	return Marionette.ItemView.extend(
	{
		events: {
			'click .authorization-delete-btn': '_onDelete',
		},

		tagName: 'tr',

		template: TokenItemViewTemplate,

		templateHelpers: TemplateHelper,

		ui: {
			deleteTokenModal: '#authorization-delete-modal'
		},

		_onDelete: function (evt)
		{
			// Get the application
			var app = this.options.app;

			// Cancel click
			evt.preventDefault();

			// Send a event to delete this token item view (and the token)
			app.vent.trigger('token:delete', this, this.model);
		}
	});
});
