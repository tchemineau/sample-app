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
		tagName: 'tr',

		template: TokenItemViewTemplate,

		templateHelpers: TemplateHelper,
	});
});
