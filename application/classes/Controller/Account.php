<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This is a simple HTTP controller only used to confirm email
 */
class Controller_Account extends Controller
{

	/**
	 * Confirm email of the given account
	 */
	public function action_confirm ()
	{
		// Get the id
		$id = $this->request->param('id');

		// This will store the error message
		$error = FALSE;

		// This will store the verification step
		$confirmed = FALSE;

		try
		{
			// Get the account service
			$account_service = Service::factory('Account');

			// Get the account
			$account = $account_service->get(array('id' => $id));

			// Verify the account if necessary
			if ($account->email_verified !== TRUE)
			{
				$account_service->update($account, array(
					'email_verified' => TRUE
				));
				$confirmed = TRUE;
			}
			// Else, set an error message
			else
			{
				$error = 'This account has already been confirmed';
			}
		}
		catch (Service_Exception_NotFound $e)
		{
			$error = 'Unable to confirm this account';
		}
		catch (Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
			$error = 'Unable to confirm this account';
		}

		$app = array(
			'name' => Kohana::$config->load('app.name'),
			'confirmed' => $confirmed,
			'error' => $error,
			'url' => URL::base(Request::current())
		);

		$view = View::factory('smarty:App/Account.Confirm.tpl');
		$view->set('APP', $app);
		$this->response->body($view);
	}

}
