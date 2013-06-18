
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

		parse: function (response, xhr)
		{
			if (_.isObject(response.data))
				return response.data;

			return response;
		},

		savedata: function ()
		{
			var me = this;

			this.save({}, {
				error: function (response, xhr)
				{
					me.trigger('account:save:error', JSON.parse(xhr.responseText), xhr);
				},
				success: function (model, response, options)
				{
					me.trigger('account:save:success', model, response, options);
				}
			});
		},

		url: function ()
		{
			return this.id ? 'api/v1/account/' + this.id : 'api/v1/account';
		}
	});

	return AccountModel;
});
