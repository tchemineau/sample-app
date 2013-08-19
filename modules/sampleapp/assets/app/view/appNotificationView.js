
define([
	'marionette',
	'helper/template',
	'text!template/appNotificationView.html'
], function(Marionette, TemplateHelper, appNotificationTemplate)
{

	var appNotificationView = Marionette.ItemView.extend(
	{
		template: appNotificationTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			var app = options.app;

			// This is the message of the notification
			var message = null;

			// This is the type of the notification
			var type = null;

			// Catch notification events
			app.vent.on('notify:error', this.notifyError, this);
			app.vent.on('notify:success', this.notifySuccess, this);
		},

		notifyError: function (message)
		{
			this.message = message;
			this.type = 'error';

			this.render();
		},

		notifySuccess: function (message)
		{
			this.message = message;
			this.type = 'success';

			this.render();
		},

		onDomRefresh: function()
		{
			if (!this.message || typeof this.message === 'undefined')
				return;

			var n = $('#appnotification');

			// Remove timeout for this object
			clearTimeout($.data(n, 'timeout'));

			// Refix the timeout
			$.data(n, 'timeout', setTimeout($.proxy(function()
			{
				n.fadeOut();
			}, this), 5000));

			// Display the notification
			n.show();
		},

		serializeData: function()
		{
			return {
				notification: {
					message: this.message,
					type: this.type
				}
			};
		}
	});

	return appNotificationView;
});

