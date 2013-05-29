
define([
	'marionette',
	'marionette.formview',
	'text!module/account/template/modifyAccount.html'
], function(Marionette, MarionetteFormView, ModifyAccountTemplate)
{
	var ModifyAccountView = Marionette.FormView.extend(
	{
		template: ModifyAccountTemplate,

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
			lastname: {
				el: 'lastname'
			}
		},

		/**
		 * Save model when submit me
		 */
		onSubmit: function (evt)
		{
			evt.preventDefault();

			this.model.set(this.serializeFormData()).savedata();
		},
	});

	return ModifyAccountView;
});
