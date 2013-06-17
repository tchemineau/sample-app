(function ()
{
	var root = this;
 
 	// Configure Requirement
	require.config({
		paths: {
			'backbone': '../../static/backbone/backbone.min',
			'bootstrap': '../../static/bootstrap/js/bootstrap.min',
			'jquery': '../../static/jquery/jquery-1.9.1.min',
			'marionette': '../../static/marionette/backbone.marionette.min',
			'marionette.formview': '../../static/marionette/backbone.marionette.formview',
			'underscore': '../../static/underscore/underscore.min'
		},
		shim: {
			'backbone': {
				deps: ['underscore', 'jquery', 'bootstrap'],
				exports: 'Backbone'
			},
			'bootstrap': {
				deps: ['jquery'],
				exports: "bootstrap"
			},
			'jquery': {
				exports: '$'
			},
			'marionette': {
				deps: ['backbone'],
				exports: 'Backbone.Marionette'
			},
			'marionette.formview': {
				deps: ['marionette']
			},
			'underscore': {
				exports: '_'
			},
		}
	});
 
	//these are defined externally so they can be used in our view templates:
	//define('jquery', [], function () { return root.jQuery; });
	define('moment', [], function ()
	{
		return root.moment;
	});
 
 	// Run the application
	require(['app'], function (App)
	{
		App.start({
			url: '/sample-app/'
		});
	});
 
})();
