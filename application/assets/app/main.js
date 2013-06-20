(function ()
{
	var root = this;
 
 	// Configure Requirement
	require.config({
		paths: {
			'backbone': '../../static/library/backbone/backbone.min',
			'backbone.session': '../../static/library/backbone/backbone.session',
			'bootstrap': '../../static/library/bootstrap/js/bootstrap.min',
			'jquery': '../../static/library/jquery/jquery-1.9.1.min',
			'marionette': '../../static/library/marionette/backbone.marionette.min',
			'marionette.formview': '../../static/library/marionette/backbone.marionette.formview',
			'underscore': '../../static/library/underscore/underscore.min'
		},
		shim: {
			'backbone': {
				deps: ['underscore', 'jquery', 'bootstrap'],
				exports: 'Backbone'
			},
			'backbone.session': {
				deps: ['backbone']
			},
			'bootstrap': {
				deps: ['jquery'],
				exports: "bootstrap"
			},
			'jquery': {
				exports: '$'
			},
			'marionette': {
				deps: ['backbone', 'backbone.session'],
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

	// Update the loading status
	require(['jquery'], function($)
	{
	        var progress = $("#appprogress");

	        window.require = (function(){
	                var orig_require = window.require;
	                return function(_list, _callback) {
	                        var callback_fn = function(_args){ _callback.apply(null, _args); }
	                        progress.show(0, function(){
	                                orig_require.call(null, _list, function(){
	                                        progress.hide(0, callback_fn(arguments));
	                                });
	                        });
	                }
	        })();
	});

 	// Run the application
	require(['app'], function (App)
	{
		App.start({
			url: '/sample-app/'
		});
	});
 
})();
