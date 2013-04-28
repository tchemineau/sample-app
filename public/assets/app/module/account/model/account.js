
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

		initialize: function (options)
		{
			this.options = options;

			var App = this.options.app;

			App.vent.on('account:save', function(model)
			{
				model.saveData();
			});
		},

		saveData: function ()
		{
			console.log('save data');
			this.save();
		},

		url: 'api/v1/account'
	});

	return AccountModel;
});
