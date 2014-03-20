define([
	'marionette',
	'helper/template',
	'module/account/collection/tokenCollection',
	'module/account/model/tokenModel',
	'module/account/view/tokenItemView',
	'module/account/view/emptyTokenCollectionView',
	'text!module/account/template/tokenCollectionView.html'
], function(
	Marionette,
	TemplateHelper,
	TokenCollection,
	TokenModel,
	TokenItemView,
	EmptyTokenCollectionView,
	TokenCollectionViewTemplate
){
	return Marionette.CompositeView.extend(
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
		 * Where to add item view
		 */
		itemViewContainer: '#tokens-list',

		/**
		 * Options pass to item view
		 */
		itemViewOptions: function (model, index)
		{
			return this.options;
		},

		/**
		 * The template of the view
		 */
		template: TokenCollectionViewTemplate,

		templateHelpers: TemplateHelper,

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
		 * Create a new token
		 */
		createToken: function (data)
		{
			// Get the application
			var app = this.options.app;

			// Create the token
			this.collection.create(data, {
				success: function()
				{
					app.vent.trigger('notify:success', TemplateHelper.__('Information saved'));
				},
				wait: true
			});
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
