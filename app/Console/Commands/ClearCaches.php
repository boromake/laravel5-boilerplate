<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCaches extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'custom:clear-all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear all compiled/cached files (views, routes, application, etc)';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		echo $this->call('clear-compiled');
		echo $this->call('cache:clear');
		echo $this->call('route:clear');
		echo $this->call('view:clear');
	}
}