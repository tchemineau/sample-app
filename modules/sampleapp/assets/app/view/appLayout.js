
define([
	'marionette',
	'view/appMenuView',
	'view/appNotificationView',
	'text!template/appLayout.html'
], function(Marionette, AppMenuView, AppNotificationView, AppTemplate)
{
	var AppLayout = Marionette.Layout.extend(
	{
		template: AppTemplate,

		regions: {
			'menu': '#appmenu',
			'notification': '#appnotification',
			'page': '#apppage'
		},

		onDomRefresh: function()
		{
			this.menu.show(new AppMenuView(this.options));
			this.notification.show(new AppNotificationView(this.options));
		},
	});

	return AppLayout;
});

