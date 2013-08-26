<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Simple application API
 */
class SampleApp_Controller_Api_V1_App extends Controller_Api_Standard
{

	/**
	 * Return a JS module to load depending of the given JS route
	 */
	public function action_require_js ()
	{
		// Get the action
		$route = $this->request->post('route');

		// Get the api service
		$api_service = Service::factory('Api');

		// If no route is given, it is a bad request
		if (is_null($route))
			return $this->response($api_service->build_response_failed('Bad request'), 400);

		// Get the application service
		$app_service = Service::factory('Application');

		// Store modules to load
		$modules = array();

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
			return $this->response($api_service->build_response_succeed('Modules found', $modules), 200);

		// In other way, return a 404 not found
		$this->response($api_service->build_response_failed('Modules not found'), 404);
	}

} // End SampleApp_Controller_Api_V1_App

