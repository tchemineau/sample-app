<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Main assets controller.
 */
class Controller_App_Assets extends Controller_Assets {

	public function action_i18n ()
	{
		// Get the i18n table
		$table = Service::factory('I18n')->get_table(Language::getLanguage());

                // Render application core layout
                $view = Twig::factory('App/I18n');
                $view->set('LANG', $table);

		// Render view to apply compression
		$output = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $view->render());

		// Return compressed output
                $this->response->body($output);
	}

}

