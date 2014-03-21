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
			'click #authorization-add-modal-ok': '_onCreateTokenConfirmed',
			'click #authorization-delete-modal-ok': '_onDeleteTokenConfirmed',
			'hidden.bs.modal #authorization-delete-modal': '_onDeleteTokenDone'
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
			deleteTokenModal: '#authorization-delete-modal',
			tokenInfo: '#authorization-info'
		},

		initialize: function (options)
		{
			// Build local options for the collection view,
			// because model attribute contains the user account.
			var opt = {app: options.app};

			// Create the token collection view
			this.tokenCollectionView = new TokenCollectionView(opt);

			// This will store a possible token view that request deletion
			this.tokenItemViewToDelete = undefined;

			// Bind to token deletion event
			this.options.app.vent.on('token:delete', this._onDeleteToken, this);
		},

		/**
		 * Do things before closing the view
		 */
		onBeforeClose: function ()
		{
			this.options.app.vent.off('token:delete', this._onDeleteToken, this);
		},

		onDomRefresh: function ()
		{
			this.tokens.show(this.tokenCollectionView);
		},

		_onCreateTokenConfirmed: function (evt)
		{
			// Cancel click
			evt.preventDefault();

			// Create the token
			this.tokenCollectionView.createToken({
				info: this.ui.tokenInfo.val()
			});

			// Hide the modal
			this.ui.addTokenModal.modal('hide');
		},

		_onDeleteToken: function (tokenItemView)
		{
			// Store the token item view that request deletion
			this.tokenItemViewToDelete = tokenItemView;

			// Hide the modal
			this.ui.deleteTokenModal.modal('show');
		},

		_onDeleteTokenConfirmed: function(evt)
		{
			// Cancel click
			evt.preventDefault();

			// Delete the token
			this.tokenCollectionView.deleteToken(this.tokenItemViewToDelete);

			// Hide the modal
			this.ui.deleteTokenModal.modal('hide');
		},

		_onDeleteTokenDone: function (evt)
		{
			// Cancel click
			evt.preventDefault();

			// Delete the reference to the token item view that request deletion
			this.tokenItemViewToDelete = undefined;
		}
	});
});
