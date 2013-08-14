<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Simple application API
 */
class Controller_Api_V1_App extends Controller_Api_Standard
{

	/**
	 * Return a JS module to load depending of the given JS route
	 */
	public function action_require_js ()
	{
		// Get the action
		$route = $this->request->post('route');

		// Get the application service
		$app_service = Service::factory('Application');

		// Get the api service
		$api_service = Service::factory('Api');

		if (!is_null($route))
		{
			// Store modules to load
			$modules = array();

			// Store return message
			$message = 'Modules not found';

			// Get JS to load
			switch ($route)
			{
				case 'init':
					$modules = $app_service->get_js_init();
					break;
				default:
					$modules = $app_service->get_js_path($route);
			}

			// Set a correct message
			if (sizeof($modules) > 0)
				$message = 'Modules found';

			// Return appropriate HTTP result
			$this->response($api_service->build_response_succeed($message, $modules), 200);
		}
		else
		{
			$this->response($api_service->build_response_failed('Bad request'), 400);
		}
	}

}

