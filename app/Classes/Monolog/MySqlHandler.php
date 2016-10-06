<?php

namespace App\Classes\Monolog;

use Monolog\Logger;
use Monolog\Formatter;
use Monolog\Handler\Curl;
use Illuminate\Database\Eloquent\Model;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Logs to a MySql database
 */
class MySqlHandler extends AbstractProcessingHandler
{
	private $model;

	public function __construct(Model $model, $level = Logger::DEBUG, $bubble = true)
	{
		$this->model = $model;

		parent::__construct($level, $bubble);
	}

	protected function write(array $record)
	{
		$this->model->uid = array_get($record, 'extra.uid', null);
		$this->model->channel = array_get($record, 'channel');
		$this->model->level_name = array_get($record, 'level_name');
		$this->model->level = array_get($record, 'level');
		$this->model->status_code = array_get($record, 'context.exception.status_code', null);
		$this->model->message = array_get($record, 'message');
		$this->model->timestamp = array_get($record, 'datetime')->format('Y-m-d H:i:s');
		$this->model->user_id = array_get($record, 'extra.user.uuid', null);
		$this->model->user_email = array_get($record, 'extra.user.email', null);
		$this->model->request_method = array_get($record, 'extra.http_method', null);
		$this->model->uri = array_get($record, 'extra.url', null);
		$this->model->ip = array_get($record, 'extra.ip', null);
		$this->model->server = array_get($record, 'extra.server', null);
		$this->model->git_branch = array_get($record, 'extra.git.branch', null);
		$this->model->git_commit = array_get($record, 'extra.git.commit', null);
		$this->model->error_file = array_get($record, 'context.exception.file', null);
		$this->model->error_line = array_get($record, 'context.exception.line', null);
		$this->model->call_class = array_get($record, 'extra.class', null);
		$this->model->call_function = array_get($record, 'extra.function', null);
		$this->model->call_file = array_get($record, 'extra.file', null);
		$this->model->call_line = array_get($record, 'extra.line', null);
		$this->model->formatted_message = array_get($record, 'formatted', null);

		$this->model->save();
	}


	protected function getDefaultFormatter()
	{
		return new JsonFormatter();
	}
}
