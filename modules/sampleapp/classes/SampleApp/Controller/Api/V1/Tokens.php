<?php defined('SYSPATH') or die('No direct script access.');

/**
 * REST API to access to tokens list
 */
class SampleApp_Controller_Api_V1_Tokens extends Controller_Api_Rest
{

	/**
	 * Return a tokens list
	 */
	public function action_get ()
	{
		// Get the token service
		$token_service = Service::factory('Token');

		// Get api service
		$api_service = Service::factory('Api');

		try
		{
			// Get current logged in user account
			$user = $api_service->get_account();

			// This will the token data representation
			$tokens = array();

			// Get tokens
			foreach ($token_service->get_all($user) as $token)
			{
				$tokens[] = array(
					'id' => $token->id(),
					'date_created' => $token->date_created,
				);
			}

			// Return appropriate HTTP code
			$this->response($api_service->build_response_succeed(
				'Tokens found',
				$tokens
			), 200);
		}
		catch (Service_Exception_NotFound $e)
		{
			$this->response($api_service->build_response_failed($e->getMEssage()), 404);
		}
		catch (Service_Exception_PermissionDenied $e)
		{
			$this->response($api_service->build_response_failed($e->getMEssage()), 403);
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$this->response($api_service->build_response_failed($e->getMessage()), 400);
		}
	}

} // End SampleApp_Controller_Api_V1_Tokens

