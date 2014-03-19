

define([
	'backbone',
	'module/account/model/tokenModel'
], function(
	Backbone,
	TokenModel
){
	return Backbone.Collection.extend(
	{
		model: TokenModel,

		parse: function (response, xhr)
		{
			if (_.isObject(response.data))
				return response.data;

			return response;
		},

		url: 'api/v1/tokens',
	});
});

