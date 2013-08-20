<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Main assets controller.
 */
class SampleApp_Controller_App_Assets extends Controller_Assets
{

	public function action_i18n ()
	{
		// Get the i18n table
		$table = Service::factory('I18n')->get_table();

                // Render application core layout
                $view = Twig::factory('App/I18n.js');
                $view->set('LANG', $table);

		// Render view to apply compression
		$output = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $view->render());

		// Return compressed output
                $this->response->body($output);
		$this->response->headers('Content-Type', 'application/javascript');
	}

} // End SampleApp_Controller_App_Assets

