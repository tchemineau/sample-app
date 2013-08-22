
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

			// Set instruction to true
			// That will popup a div with a help message
			this.isInstruction = true;

			// Catch event which needs update
			app.vent.on('account:updated:success', this.render, this);
			app.vent.on('login:success:account', this.render, this);
			app.vent.on('logout:success:account', this.render, this);
		},

		onDomRefresh: function()
		{
			// This is this element
			var me = this;

			// Manage instruction
			if (this.isInstruction)
			{
				var el = $('#btn-sign-up');

				clearTimeout($.data(el, 'timeout1'));
				clearTimeout($.data(el, 'timeout2'));

				$.data(el, 'timeout1', setTimeout($.proxy(function()
				{
					me.isInstruction = false;
					el.tooltip('show');

					$.data(el, 'timeout2', setTimeout($.proxy(function()
					{
						el.tooltip('hide');
					}, me), 5000));
				}, me), 2000));
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

