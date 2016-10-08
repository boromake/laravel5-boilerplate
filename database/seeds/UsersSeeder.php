<?php

use App\Models\Users\User;
use App\Enums\UserAccountTypes;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach(UserAccountTypes::labels() as $key => $label)
		{
			User::create([
				'email' => snake_case($label . '@gmail.com'),
				'password' => 'password',
				'account_type' => $key,
			]);
		}


	}
}