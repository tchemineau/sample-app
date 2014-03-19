
define([
	'marionette',
	'helper/template',
	'module/account/view/tokenCollectionView',
	'text!module/account/template/modifyAccountAuthorizationsLayout.html'
], function(
	Marionette,
	TemplateHelper,
	TokenCollectionView,
	ModifyAccountAuthorizationsViewTemplate
){
	return Marionette.Layout.extend(
	{
		template: ModifyAccountAuthorizationsViewTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Regions
		 */
		regions: {
			'tokens': '#tokens-list',
		},

		initialize: function (options)
		{
			// Build local options for the collection view,
			// because model attribute contains the user account.
			var opt = {app: options.app};

			this.tokenCollectionView = new TokenCollectionView(opt);
		},

		onDomRefresh: function ()
		{
			this.tokens.show(this.tokenCollectionView);
		}
	});
});

