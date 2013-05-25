<?php defined('SYSPATH') or die();

/**
 * A service class to send emails
 */
class Service_Email extends Service
{

	/**
	 * Build simple email content
	 */
	public static function build_content ( $view, $data = array() )
	{
		// Calculate website URL from current request
		$url = URL::base(Request::current());

		// Load the mail template
		$content = View::factory('smarty:Mail/'.$view.'.tpl');

		// Set data
		foreach ($data as $key => $value)
			$content->set($key, $value);

		// Set calculate variables
		$content->set('url', $url);

		return $content;
	}

	/**
	 * Build simple email headers
	 */
	public static function build_headers ( $to, $title, $reply = FALSE, $from = NULL )
	{
		if (is_null($from))
		{
			$from = array(
				Kohana::$config->load('app.email_from_address'),
				Kohana::$config->load('app.email_from_name')
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

}

