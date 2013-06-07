<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is the default controller which deserved the main page.
 */
class Controller_Welcome extends Controller
{

	/**
	 * Default action which render the main page.
	 */
	public function action_index()
	{
		$app = array(
			'name' => Kohana::$config->load('app.name'),
			'fragment' => $this->request->param('fragment'),
			'url' => URL::base($this->request)
		);

		$view = View::factory('smarty:App/Welcome.tpl');
		$view->set('APP', $app);
		$this->response->body($view);
	}

}
