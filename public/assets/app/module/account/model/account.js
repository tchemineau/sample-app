
define([
	'backbone',
	'marionette',
	'app'
], function(Backbone, Marionette, App)
{
	var AccountModel = Backbone.Model.extend(
	{
		defaults: {
			firstname: '',
			lastname: ''
		},

		initialize: function (options)
		{
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
