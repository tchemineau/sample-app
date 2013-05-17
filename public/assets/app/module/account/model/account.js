
define([
	'backbone',
	'marionette'
], function(Backbone, Marionette)
{
	var AccountModel = Backbone.Model.extend(
	{
		defaults: {
			email: '',
			firstname: '',
			lastname: '',
			password: ''
		},

		validation: {
			email: {
				required: true,
				pattern: 'email'
			},
			password: {
				required: true,
				minLength: 8
			}
		},

		saveData: function ()
		{
			this.save();
		},

		url: 'api/v1/account'
	});

	return AccountModel;
});
