define([
	'marionette',
	'helper/template',
	'module/account/collection/tokenCollection',
	'module/account/view/tokenItemView',
	'module/account/view/emptyTokenCollectionView'
], function(
	Marionette,
	TemplateHelper,
	TokenCollection,
	TokenItemView,
	EmptyTokenCollectionView
){
	return Marionette.CollectionView.extend(
	{
		/**
		 * The empty view
		 */
		emptyView: EmptyTokenCollectionView,

		/**
		 * The view for each collection item
		 */
		itemView: TokenItemView,

		/**
		 * Create an empty tokens list when initialize this view
		 */
		initialize: function (options)
		{
			// Get the application
			var app = options.app;

			// Create the collection object
			this.collection = new TokenCollection([], this.options);
		},

		/**
		 * Fetch collection each time the view is refreshed
		 */
		onDomRefresh: function ()
		{
			// Get the application
			var app = this.options.app;

			// Fetch collection if the user is connected
			if (app.user)
				this._fetchTokens();
		},

		/**
		 * Fetch tokens
		 */
		_fetchTokens: function ()
		{
			// Get the application
			var app = this.options.app;

			// Fetch it
			this.collection.fetch({
				error: function()
				{
					app.vent.trigger('page:error');
				},
				success: function() {}
			});
		}
	});
});
