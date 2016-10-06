<?php

namespace App\Classes\Monolog;

use Monolog\Logger;
use Monolog\Handler\Curl;
use Monolog\Handler\MailHandler;
use Monolog\Formatter\HtmlFormatter;


/**
 * MailgunHandler uses cURL to send the emails to the MailGun API
 */
class MailgunHandler extends MailHandler
{
	protected $api_key;

	/**
	 * @param string                  $api_key  A valid Mailgun API key
	 * @param int                     $level    The minimum logging level at which this handler will be triggered
	 * @param Boolean                 $bubble   Whether the messages that are handled can bubble up the stack or not
	 */
	public function __construct($api_key, $level = Logger::ERROR, $bubble = true)
	{
		parent::__construct($level, $bubble);

		$this->api_key = $api_key;
	}

	protected function send($content, array $records)
	{
		// dont send an email for 404's (causes too much email spam)
		if(array_get($records,'0.context.exception.status_code') == "404")
		{
			return;
		}

		//generate the email body
		$view = \View::make('emails.error_template', ['content' => $content]);
		$full_html_content = $view->render();

		//generate the subject
		$subject = array_get($records, '0.channel', '(missing channel)') . ' | ' .
				   array_get($records, '0.level_name', '(missing level)') . ' | ' .
				   str_limit(array_get($records, '0.message', '(missing message'), 50);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $this->api_key);
		curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'. config('services.mailgun.domain') . '/messages');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			'from' => config('mail.from.name') . ' <' . config('mail.from.address') . '>',
			'to' => config('emails.webmaster'),
			'subject' => $subject,
			'html' => $full_html_content,
		)));

		Curl\Util::execute($ch);
	}

	protected function getDefaultFormatter()
	{
		return new HtmlFormatter();
	}
}
