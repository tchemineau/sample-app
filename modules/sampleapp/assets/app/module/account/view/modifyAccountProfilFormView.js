
define([
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!module/account/template/modifyAccountProfilFormView.html'
], function(Marionette, MarionetteFormView, TemplateHelper, ModifyAccountProfilFormViewTemplate)
{
	var accountModified = false;

	var modifyAccountProfilFormView = Marionette.FormView.extend(
	{
		template: ModifyAccountProfilFormViewTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			this.listenTo(this.model, 'account:save:success', this.onAccountSave);
		},

		/**
		 * Declare variables to access template content
		 */
		ui: {
			firstname: '#account-firstname',
			lastname: '#account-lastname'
		},

		/**
		 * Declare inputs
		 */
		fields: {
			firstname: {
				el: 'firstname'
			},
			gravatar_email: {
				el: 'gravatar_email'
			},
			lastname: {
				el: 'lastname'
			}
		},

		/**
		 * What to do when account information has been save
		 */
		onAccountSave: function ()
		{
			var app = this.options.app;

			accountModified = true;

			app.vent.trigger('account:updated', this.model);
			app.vent.trigger('notify:success', TemplateHelper.__('Information saved'));

			this.render();
		},

		/**
		 * Save model when submit me
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			this.model.set(this.serializeFormData()).savedata();
		},

		/**
		 * Serialize data for the template
		 */
		serializeData: function ()
		{
			var app = this.options.app;

			return $.extend({}, this.model.toJSON(), {
				accountModified: accountModified,
				url: app.url
			});
		}
	});

	return modifyAccountProfilFormView;
});
