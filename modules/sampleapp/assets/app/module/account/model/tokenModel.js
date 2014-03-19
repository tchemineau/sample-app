
define([
	'backbone'
], function(
	Backbone
){
	return Backbone.Model.extend(
	{
		defaults: {
			date_created: '',
			type: '',
			info: ''
		},

		parse: function (response, xhr)
		{
			if (_.isObject(response.data))
				return response.data;

			return response;
		},

		url: function ()
		{
			return 'api/v1/token/' + (this.id ? this.id : '');
		}
	});
});
