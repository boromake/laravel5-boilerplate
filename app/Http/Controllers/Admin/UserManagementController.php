<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserAccountTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\LoginHistory;

class UserManagementController extends Controller
{

	/**
	 * List all users (filtered if applicable)
	 *
	 * GET /admin/users/
	 */
	public function showUsers(Request $request)
	{
		// see if this is a fresh page load, or if the user submitted the page to filter the results
		$is_fresh_page_load = !$request->has('submit');

		// get the form data
		$form_data = $request->all();

		// set defaults if this is a fresh page load
		if($is_fresh_page_load)
		{
			$form_data['account_type'] = ''; // default to all user types
			$form_data['sort_by'] = 'last_login';
			$form_data['sort_direction'] = 'desc';
		}

		$query_builder = User::with('login_history');

		// filter by account type
		if(array_get($form_data, 'account_type', '') != '')
		{
			$query_builder->where('account_type', $form_data['account_type']);
		}

		// filter by deleted / not deleted
		if(array_get($form_data, 'is_active', ''))
		{
			$query_builder->withTrashed();
		}

		// sorting
		// we need to do this in-memory with php, since we might be sorting by calculated fields
		$results = $query_builder->get();

		if($form_data['sort_direction'] == 'asc')
		{
			$results = $results->sortBy($form_data['sort_by']);
		}
		else
		{
			$results = $results->sortByDesc($form_data['sort_by']);
		}

		return view('admin.users.users_list',
			[
				'users' => $results,
				'form_data' => $form_data
			]
		);
	}


	/**
	 * Show login history of all users
	 *
	 * GET /admin/users/login-history/{id?}
	 *
	 * @param int $id (optional)
	 */
	public function showLoginHistory(Request $request, $id = null)
	{
		// the user we are specifically filtering by, if applicable
		$filtered_user = null;

		$query_builder = LoginHistory::with('user');

		// filter by specific user, if applicable
		if(!is_null($id))
		{
			$filtered_user = User::findOrFail($id);
			$query_builder->where('user_id', $filtered_user->uuid);
		}

		// take arbitrary number of results, in this case 200
		$login_history = $query_builder->orderBy('id', 'desc')
				->take(200)
				->get();

		return view('admin.users.login_history', [
			'login_history' => $login_history,
			'filtered_user' => $filtered_user,
		]);
	}

}