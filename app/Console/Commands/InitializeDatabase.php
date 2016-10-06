<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitializeDatabase extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'custom:initialize-mysql-database';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize (create) this application\'s database';

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
		$mysql_config = config('database.connections.mysql');
		$database = array_get($mysql_config, 'database');
		$charset = array_get($mysql_config, 'charset');
		$collation = array_get($mysql_config, 'collation');
		$username = array_get($mysql_config, 'username');
		$password = array_get($mysql_config, 'password');

		$this->info('If it doesn\'t already exist, this command will create the database: ' . $database);
		$this->info('with charset: ' . $charset);
		$this->info('with collation: ' . $collation);

		if ($this->confirm('Do you wish to continue?'))
		{
			// create our application's database
			$create_db_statement = 'CREATE DATABASE IF NOT EXISTS ' . $database .
								   ' DEFAULT CHARACTER SET ' . $charset .
								   ' DEFAULT COLLATE ' . $collation;

			// create the database user that the application will use to access the database
			$create_user_statement = 'CREATE USER IF NOT EXISTS \'' . $username . '\'@\'%\' IDENTIFIED BY \'' . $password . '\'';
			$create_user_grant_statement = 'GRANT SELECT, INSERT, UPDATE, DELETE ON ' . $database . '.* TO \'' . $username . '\'@\'%\'';

			\DB::connection('mysql_admin')->statement($create_db_statement);
			\DB::connection('mysql_admin')->statement($create_user_statement);
			\DB::connection('mysql_admin')->statement($create_user_grant_statement);

			// create the migrations table used by Laravel
			$this->call('migrate:install', [
				'--database' => 'mysql_admin'
			]);
		}
	}
}
