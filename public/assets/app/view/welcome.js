
define([
	'marionette',
	'text!template/welcome.html'
], function(Marionette, WelcomeTemplate)
{
	var WelcomeView = Marionette.ItemView.extend(
	{
		template: WelcomeTemplate,
	});

	return WelcomeView;
});
