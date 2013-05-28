
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
