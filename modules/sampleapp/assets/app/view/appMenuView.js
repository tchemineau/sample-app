
define([
	'marionette',
	'helper/template',
	'text!template/appMenuView.html'
], function(Marionette, TemplateHelper, appMenuTemplate)
{
	var appMenuView = Marionette.ItemView.extend(
	{
		template: appMenuTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			var app = options.app;

			// Set instructions to false
			this.isInstruction = false;

			app.vent.on('account:updated:success', this.render, this);
			app.vent.on('login:success:account', this.render, this);
			app.vent.on('logout:success:account', this.render, this);
		},

		onDomRefresh: function()
		{
			// This is this element
			var me = this;

			// Manage instruction
			if (!this.isInstruction)
			{
				var el = $('#btn-sign-up');
				clearTimeout($.data(el, 'timeout'));

				$.data(el, 'timeout', setTimeout($.proxy(function()
				{
					me.isInstruction = true;
					el.tooltip('hide');
				}, this), 8000));

				el.tooltip('show');
			}
		},

		serializeData: function()
		{
			var app = this.options.app;

			return {
				user: app.user ? app.user.toJSON() : {},
				url: app.url
			};
		}
	});

	return appMenuView;
});

