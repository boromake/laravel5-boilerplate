<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/********************************************
		 * USERS
		 ********************************************/
		Schema::connection('mysql_admin')->create('users', function (Blueprint $table) {

			$table->increments('id');
			$table->uuid('uuid')->unique();
			$table->string('email')->unique();
			$table->string('display_name')->nullable();
			$table->string('password');
			$table->tinyInteger('account_type')->default(1);

			$table->rememberToken();
			$table->timestamps();

			$table->softDeletes();
		});


		/********************************************
		 * USER_LOGIN_HISTORY
		 ********************************************/
		Schema::connection('mysql_admin')->create('user_login_history', function (Blueprint $table)
		{
			$table->increments('id');
			$table->uuid('user_id');

			$table->string('ip')->nullable();
			$table->boolean('used_login_cookie')->nullable();
			$table->integer('minutes_since_last_login')->nullable();
			$table->string('server_ip')->nullable();
			$table->string('server_name')->nullable();

			$table->timestamps();

			$table->index('created_at');
			$table->foreign('user_id')
				->references('uuid')->on('users')
				->onDelete('cascade')
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
		Schema::connection('mysql_admin')->dropIfExists('user_login_history');
		Schema::connection('mysql_admin')->dropIfExists('users');
	}
}
