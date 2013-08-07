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

		try
		{
			// Get the JS to load
			$module = $app_service->get_js_route($route);

			// Return appropriate HTTP result
			$this->response($api_service->build_response_succeed(
				'JS module found',
				array(
					'path' => $module
				)
			), 200);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response_failed('Bad request'), 400);
		}
	}

}

