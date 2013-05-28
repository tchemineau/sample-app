define([
	'marionette',
	'controller'
], function(Marionette, AppController)
{
	var AppRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
			'login': 'login',
			'logout': 'logout',
			'': 'welcome',
			'*actions': 'default'
		},

		controller: AppController,

		initialize: function(options)
		{
			var App = options.app;
			var Url = options.url;

			this.controller.initialize({
				app: options.app
			})

			// Catch clicks on every a links
			$(document).on('click', 'a:not([data-bypass])', function (evt)
			{
				var href = $(this).attr('href');
				var protocol = this.protocol + '//';

				if (href.slice(protocol.length) !== protocol)
				{
					evt.preventDefault();
					App.router.navigate(href, {trigger: true});
				}
			});

			// Start history
			Backbone.history.start({
				pushState: false,
				root: Url
			});
		}
	});

	return AppRouter;
});
