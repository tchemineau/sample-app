<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is the default controller which deserved the main page.
 */
class SampleApp_Controller_App_Welcome extends Controller
{

	/**
	 * Default action which render the main page.
	 */
	public function action_index()
	{
		// Build configuration
		$app = array(
			'name' => Kohana::$config->load('app.name'),
			'fragment' => $this->request->param('fragment'),
			'url' => URL::base()
		);

		// Render application core layout
		$view = Twig::factory('App/Welcome');
		$view->set('APP', $app);
		$this->response->body($view);
	}

} // End SampleApp_Controller_App_Welcome

