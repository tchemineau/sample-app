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

		_onDelete: function (evt)
		{
			// Cancel click
			evt.preventDefault();

			// Remove this token
			this.model.destroy();
		}
	});
});
