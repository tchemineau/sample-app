define([
	'marionette',
	'controller'
], function(Marionette, AppController)
{
	var AppRouter = Marionette.AppRouter.extend(
	{
		appRoutes: {
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

			$(document).on('click', 'a:not([data-bypass])', function (evt)
			{
				var href = $(this).attr('href');
				var protocol = this.protocol + '//';

				if (href.slice(protocol.length) !== protocol)
				{
					evt.preventDefault();
					App.router.navigate(href, true);
				}
			});

			Backbone.history.start({
				pushState: true,
				root: Url
			});
		}
	});

	return AppRouter;
});
