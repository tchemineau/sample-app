
define([
	'marionette',
	'marionette.formview',
	'helper/template',
	'text!module/account/template/modifyAccountProfileFormView.html'
], function(
	Marionette,
	MarionetteFormView,
	TemplateHelper,
	ModifyAccountProfileFormViewTemplate
){
	return Marionette.FormView.extend(
	{
		template: ModifyAccountProfileFormViewTemplate,

		templateHelpers: TemplateHelper,

		initialize: function (options)
		{
			this.accountModified = false;

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

			this.accountModified = true;

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
				accountModified: this.accountModified,
				url: app.url
			});
		}
	});
});
