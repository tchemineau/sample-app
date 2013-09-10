
define([
	'marionette',
	'helper/template',
	'text!module/account/template/confirmAccountView.html'
], function(Marionette, TemplateHelper, ConfirmAccountTemplate)
{
	var ConfirmAccountView = Marionette.ItemView.extend(
	{
		template: ConfirmAccountTemplate,

		templateHelpers: TemplateHelper,

		/**
		 * Do stuff at initialization
		 */
		initialize: function (options)
		{
			var app = options.app;

			this.checked = false;
			this.confirmed = false;

			app.vent.on('account:confirm', this.render, this);

			this.confirmAccount();
		},

		/**
		 * Do things before closing the view
		 */
		onBeforeClose: function ()
		{
			this.options.app.vent.off('account:confirm', this.render, this);
		},

		/**
		 * Confirm account
		 */
		confirmAccount: function ()
		{
			// This store this object
			var me = this;

			// Get application
			var app = this.options.app;

			// Do the request to log the user
			$.ajax(
			{
				url: 'api/v1/auth/confirm_email',
				type: 'POST',
				dataType: 'json',
				data: { 'token': me.options.token },
				success: function (response)
				{
					me.checked = true;
					me.confirmed = true;

					app.vent.trigger('account:confirm');
				},
				error: function (xhr, status)
				{
					me.checked = true;
					me.confirmed = false;

					app.vent.trigger('account:confirm');
				}
			});
		},

		serializeData: function()
		{
			var app = this.options.app;

			return {
				checked: this.checked,
				confirmed: this.confirmed,
				url: app.url
			};
		}
	});

	return ConfirmAccountView;
});

