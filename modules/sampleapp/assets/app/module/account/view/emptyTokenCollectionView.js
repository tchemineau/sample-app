define([
	'marionette',
	'helper/template',
	'text!module/account/template/emptyTokenCollectionView.html'
], function(
	Marionette,
	TemplateHelper,
	EmptyTokenCollectionViewTemplate
){
	return Marionette.ItemView.extend(
	{
		template: EmptyTokenCollectionViewTemplate,

		templateHelpers: TemplateHelper,
	});
});
