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
		 * Events
		 */
		events: {
			'click #authorization-add-modal-ok': '_onCreateToken',
		},

		/**
		 * Regions
		 */
		regions: {
			'tokens': '#tokens',
		},

		/**
		 * UI elements
		 */
		ui: {
			addTokenModal: '#authorization-add-modal',
			tokenInfo: '#authorization-info'
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
		},

		_onCreateToken: function (evt)
		{
			// Cancel click
			evt.preventDefault();

			// Create the token
			this.tokenCollectionView.createToken({
				info: this.ui.tokenInfo.val()
			});

			// Hide the modal
			this.ui.addTokenModal.modal('hide');
		}
	});
});
