<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Emailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Logging\Log;
use Carbon\Carbon;

class LogsController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| GENERAL LOGS
	|--------------------------------------------------------------------------
	*/

	/**
	 * Show general logs history
	 *
	 * GET /admin/logs/general/
	 */
	public function showGeneralLogs(Request $request)
	{
		// get the form data
		$form_data = $request->all();

		// always get last 2-weeks of logs
		$query_builder = Log::whereDate('timestamp', '>=', Carbon::now()->subWeeks(2));

		// filter by level
		if(!empty(array_get($form_data, 'level')))
		{
			$query_builder->where('level', $form_data['level']);
		}

		// by default we want to filter out 404's, unless user explicitly requests to include them
		if(!array_get($form_data, 'include_404'))
		{
			//$query_builder->where('status_code', '<>', '404');
			$query_builder->where(function ($query)
			{
				$query->whereNull('status_code')
					  ->orWhere('status_code', '<>', '404');
			});
		}

		// filter by user_email
		if(!empty(array_get($form_data, 'user_email')))
		{
			$query_builder->where('user_email', $form_data['user_email']);
		}

		// filter by uri
		if(!empty(array_get($form_data, 'uri', '')))
		{
			$query_builder->where('uri', $form_data['uri']);
		}

		$query_builder->orderBy('timestamp', 'desc');
		$logs = $query_builder->get();

		return view('admin.logs.general_list', ['form_data' => $form_data, 'logs' => $logs]);
	}

	/**
	 * Show a specific general log record
	 *
	 * GET /admin/logs/general/{id}
	 */
	public function showGeneralLogDetails($id)
	{
		$log_details = Log::findOrFail($id)->toArray();

		return view('admin.logs.general_detail', ['log_details' => $log_details]);
	}
}