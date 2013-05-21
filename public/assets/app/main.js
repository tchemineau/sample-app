(function ()
{
	var root = this;
 
 	// Configure Requirement
	require.config({
		paths: {
			'backbone': '../lib/backbone.min',
			'bootstrap': '../lib/bootstrap/js/bootstrap.min',
			'jquery': '../lib/jquery-1.9.1.min',
			'marionette': '../lib/backbone.marionette.min',
			//'marionette.formview': '../lib/backbone.marionette.formview.min',
			'marionette.formview': '../lib/backbone.marionette.formview',
			'underscore': '../lib/underscore.min'
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
