
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

		saveData: function (options)
		{
			this.save({}, options);
		},

		url: 'api/v1/account'
	});

	return AccountModel;
});
