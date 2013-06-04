
define([
	'marionette',
	'view/appMenuView',
	'text!template/appLayout.html'
], function(Marionette, AppMenuView, AppTemplate)
{
	var AppLayout = Marionette.Layout.extend(
	{
		template: AppTemplate,

		regions: {
			user: '#appuser',
			menu: '#appmenu',
			page: '#apppage'
		},

		onDomRefresh: function()
		{
			this.menu.show(new AppMenuView(this.options));
		},
	});

	return AppLayout;
});

