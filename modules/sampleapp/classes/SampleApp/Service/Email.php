<?php defined('SYSPATH') or die();

/**
 * A service class to send emails
 */
class SampleApp_Service_Email extends Service
{

	/**
	 * Build simple email content
	 */
	public static function build_content ( $view, $data = array() )
	{
		// Load the mail template
		$content = Twig::factory('Mail/'.$view);

		// Set data
		foreach ($data as $key => $value)
			$content->set($key, $value);

		// Set application name
		$content->set('appname', Kohana::$config->load('app.name'));

		// Set website URL from current request
		$content->set('appurl', URL::base(Request::current()));

		return $content;
	}

	/**
	 * Build simple email headers
	 */
	public static function build_headers ( $to, $title, $reply = FALSE, $from = NULL )
	{
		if (is_null($from))
		{
			$app_name = Kohana::$config->load('app.name');
			$from_addr = Kohana::$config->load('app.email_from_address');
			$from_name = Kohana::$config->load('app.email_from_name');

			$from = array(
				$from_addr,
				Service::factory('I18n')->get_string($from_name, array(':title' => $app_name))
			);
		}

		return array(
			'from' => $from,
			'to' => $to,
			'title' => $title,
			'reply' => $reply
		);
	}

	/**
	 * Send a email
	 *
	 * @param {array} $headers
	 * @param {View} $content
	 * @return {boolean}
	 */
	public static function send ( $headers, $content )
	{
		if (!Kohana::$config->load('app.email_enabled'))
			return TRUE;

		try
		{
			// Set headers
			foreach ($headers as $key => $value)
				$content->set($key, $value);

			// Instantiate the mailer
			$mailer = Email::connect();

			// Send the mail
			$nbmails = Email::send(
				$headers['to'],
				$headers['from'],
				$headers['title'],
				(string) $content,
				true, // This is HTML content
				$headers['reply']
			);

			return $nbmails > 0;
		}
		catch (Exception $e)
		{
			Kohana::$log->add(Log::ERROR, "Could not send email to :email\n:error", array(
				':email' => $headers['to'],
				':error' => (string) $e
			));

			return FALSE;
		}
	}

} // End SampleApp_Service_Email

