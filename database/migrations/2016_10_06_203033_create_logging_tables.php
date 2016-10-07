<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggingTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/********************************************
		 * LOGS_LOGGING
		 * Used by the Monolog MySqlHandler
		 ********************************************/
		Schema::connection('mysql_admin')->create('logs_logging', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('uid', 10);
			$table->string('channel', 50);
			$table->string('level_name', 50);
			$table->integer('level');
			$table->integer('status_code')->nullable();
			$table->text('message');
			$table->dateTime('timestamp');
			$table->uuid('user_id')->nullable();
			$table->string('user_email', 100)->nullable();
			$table->string('request_method', 25)->nullable();
			$table->string('uri', 500)->nullable();
			$table->string('ip', 20)->nullable();
			$table->string('server', 100)->nullable();
			$table->string('git_branch', 50)->nullable();
			$table->string('git_commit', 50)->nullable();
			$table->string('error_file', 255)->nullable();
			$table->integer('error_line')->nullable();
			$table->string('call_file', 255)->nullable();
			$table->string('call_function', 255)->nullable();
			$table->string('call_class', 255)->nullable();
			$table->integer('call_line')->nullable();
			$table->json('formatted_message')->nullable();

			$table->timestamps();

			$table->index('channel');
			$table->index('level_name');
			$table->index('user_id');
			$table->index('status_code');
		});


		/********************************************
		 * LOGS_EVENTS
		 * Log "general" events
		 ********************************************/
		Schema::connection('mysql_admin')->create('logs_events', function (Blueprint $table)
		{
			$table->increments('id');

			$table->uuid('user_id')->nullable();
			$table->tinyInteger('event_id', false, true);
			$table->string('description', 150)->nullable();
			$table->json('extra_info')->nullable();

			$table->timestamps();

			$table->index('created_at');

			$table->foreign('user_id')
				->references('uuid')->on('users')
				->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('mysql_admin')->dropIfExists('logs_events');
		Schema::connection('mysql_admin')->dropIfExists('logs_logging');
	}
}
