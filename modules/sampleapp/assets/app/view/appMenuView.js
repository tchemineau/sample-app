
define([
	'backbone',
	'marionette',
	'helper/template',
	'text!template/appMenuView.html'
], function(Backbone, Marionette, TemplateHelper, appMenuTemplate)
{
	var appMenuView = Marionette.ItemView.extend(
	{
		template: appMenuTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			var app = options.app;

			// Set instruction to true
			// That will popup a div with a help message
			this.isInstruction = true;

			// Catch event which needs update
			app.vent.on('account:updated:success', this.render, this);
			app.vent.on('login:success:account', this.render, this);
			app.vent.on('logout:success:account', this.render, this);

			// Catching application dom refreshing instead
			app.root.currentView.page.on('show', this._updateMenu, this);
		},

		serializeData: function()
		{
			var app = this.options.app;

			return {
				title: app.title,
				url: app.url,
				user: app.user ? app.user.toJSON() : {}
			};
		},

		_updateMenu: function()
		{
			// This is this element
			var me = this;

			// Manage instruction
			if (this.isInstruction && Backbone.history.getFragment() == '')
			{
				var el = $('#btn-sign-up');

				clearTimeout($.data(el, 'timeout1'));
				clearTimeout($.data(el, 'timeout2'));

				$.data(el, 'timeout1', setTimeout($.proxy(function()
				{
					me.isInstruction = false;
					el.popover('show');

					$.data(el, 'timeout2', setTimeout($.proxy(function()
					{
						el.popover('hide');
					}, me), 5000));
				}, me), 2000));
			}
		}
	});

	return appMenuView;
});

