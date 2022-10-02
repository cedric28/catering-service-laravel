<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Planner;
use App\PlannerTask;
use Illuminate\Support\Facades\DB;

class PlannerFetchController extends Controller
{
	public function fetchPendingPlanner(Request $request)
	{
		ini_set('max_execution_time', 100);
		//column list in the table Prpducts
		$columns = array(
			0 => 'event_name',
			1 => 'event_venue',
			2 => 'no_of_guests',
			3 => 'event_date',
			4 => 'event_time',
			5 => 'created_at',
			6 => 'action'
		);

		//get the total number of data in Category table
		$totalData = Planner::where('status', 'pending')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the Category datatable
		if (empty($request->input('search.value'))) {
			//get all the category data
			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where([
					['planners.status', 'pending'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data
			$totalFiltered = Planner::where('status', 'pending')->count();
		} else {
			$search = $request->input('search.value');

			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where(function ($query) use ($search) {
					$query->where('planners.event_name', 'like', '%' . $search . '%')
						->orWhere('planners.event_venue', 'like', "%{$search}%")
						->orWhere('planners.no_of_guests', 'like', "%{$search}%")
						->orWhere('planners.event_date', 'like', "%{$search}%")
						->orWhere('planners.event_time', 'like', "%{$search}%")
						->orWhere('planners.status', 'like', "%{$search}%")
						->orWhere('planners.customer_fullname', 'like', "%{$search}%")
						->orWhere('main_packages.name', 'like', "%{$search}%")
						->orWhere('packages.name', 'like', "%{$search}%")
						->orWhere('planners.created_at', 'like', "%{$search}%");
				})
				->where([
					['planners.status', 'pending'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where(function ($query) use ($search) {
					$query->where('planners.event_name', 'like', '%' . $search . '%')
						->orWhere('planners.event_venue', 'like', "%{$search}%")
						->orWhere('planners.no_of_guests', 'like', "%{$search}%")
						->orWhere('planners.event_date', 'like', "%{$search}%")
						->orWhere('planners.event_time', 'like', "%{$search}%")
						->orWhere('planners.status', 'like', "%{$search}%")
						->orWhere('planners.customer_fullname', 'like', "%{$search}%")
						->orWhere('main_packages.name', 'like', "%{$search}%")
						->orWhere('packages.name', 'like', "%{$search}%")
						->orWhere('planners.created_at', 'like', "%{$search}%");
				})
				->where([
					['planners.status', 'pending'],
					['planners.deleted_at', '=', null]
				])->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
				$nestedData['event_date_and_time'] = $r->event_date . ' ' . $r->event_time;
				$nestedData['event_type_and_package'] = $r->package_name . ' - ' . $r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
				$nestedData['customer_fullname'] = ucwords($r->customer_fullname);
				$nestedData['event_status'] = '<span title="Danger" class="badge bg-info">PENDING</span>';
				$nestedData['payment_status'] = $r->payment_status;
				$nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
				$nestedData['action'] = '
                    <button name="show" id="show-pending-planner" data-id="' . $r->id . '" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-pending-planner" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete-pending-planner" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
				';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"			    => intval($request->input('draw')),
			"recordsTotal"	    => intval($totalData),
			"recordsFiltered"   => intval($totalFiltered),
			"data"			    => $data
		);

		//return the data in json response
		return response()->json($json_data);
	}

	public function fetchOnGoingPlanner(Request $request)
	{
		ini_set('max_execution_time', 100);
		//column list in the table Prpducts
		$columns = array(
			0 => 'event_name',
			1 => 'event_venue',
			2 => 'no_of_guests',
			3 => 'event_date',
			4 => 'event_time',
			5 => 'created_at',
			6 => 'action'
		);

		//get the total number of data in Category table
		$totalData = Planner::where('status', 'on-going')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the Category datatable
		if (empty($request->input('search.value'))) {
			//get all the category data
			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where([
					['planners.status', '=', 'on-going'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data
			$totalFiltered = Planner::where('status', 'on-going')->count();
		} else {
			$search = $request->input('search.value');

			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where(function ($query) use ($search) {
					$query->where('planners.event_name', 'like', '%' . $search . '%')
						->orWhere('planners.event_venue', 'like', "%{$search}%")
						->orWhere('planners.no_of_guests', 'like', "%{$search}%")
						->orWhere('planners.event_date', 'like', "%{$search}%")
						->orWhere('planners.event_time', 'like', "%{$search}%")
						->orWhere('planners.status', 'like', "%{$search}%")
						->orWhere('planners.customer_fullname', 'like', "%{$search}%")
						->orWhere('main_packages.name', 'like', "%{$search}%")
						->orWhere('packages.name', 'like', "%{$search}%")
						->orWhere('planners.created_at', 'like', "%{$search}%");
				})
				->where([
					['planners.status', '=', 'on-going'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::where('status', 'on-going')->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
				$nestedData['event_date_and_time'] = $r->event_date . ' ' . $r->event_time;
				$nestedData['event_type_and_package'] = $r->package_name . ' - ' . $r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
				$nestedData['customer_fullname'] = ucwords($r->customer_fullname);
				$nestedData['event_status'] = '<span title="Danger" class="badge bg-primary">ON-GOING</span>';
				$nestedData['payment_status'] = $r->payment_status;
				$nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
				$nestedData['action'] = '
                    <button name="show" id="show-on-going-planner" data-id="' . $r->id . '" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-on-going-planner" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete-on-going-planner" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
				';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"			    => intval($request->input('draw')),
			"recordsTotal"	    => intval($totalData),
			"recordsFiltered"   => intval($totalFiltered),
			"data"			    => $data
		);

		//return the data in json response
		return response()->json($json_data);
	}

	public function fetchDonePlanner(Request $request)
	{
		ini_set('max_execution_time', 100);
		//column list in the table Prpducts
		$columns = array(
			0 => 'event_name',
			1 => 'event_venue',
			2 => 'no_of_guests',
			3 => 'event_date',
			4 => 'event_time',
			5 => 'created_at',
			6 => 'action'
		);

		//get the total number of data in Category table
		$totalData = Planner::where('status', 'completed')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the Category datatable
		if (empty($request->input('search.value'))) {
			//get all the category data
			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where([
					['planners.status', 'completed'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data
			$totalFiltered = Planner::where('status', 'completed')->count();
		} else {
			$search = $request->input('search.value');

			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where(function ($query) use ($search) {
					$query->where('planners.event_name', 'like', '%' . $search . '%')
						->orWhere('planners.event_venue', 'like', "%{$search}%")
						->orWhere('planners.no_of_guests', 'like', "%{$search}%")
						->orWhere('planners.event_date', 'like', "%{$search}%")
						->orWhere('planners.event_time', 'like', "%{$search}%")
						->orWhere('planners.status', 'like', "%{$search}%")
						->orWhere('planners.customer_fullname', 'like', "%{$search}%")
						->orWhere('main_packages.name', 'like', "%{$search}%")
						->orWhere('packages.name', 'like', "%{$search}%")
						->orWhere('planners.created_at', 'like', "%{$search}%");
				})
				->where([
					['planners.status', 'completed'],
					['planners.deleted_at', '=', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::where('status', 'completed')->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
				$nestedData['event_date_and_time'] = $r->event_date . ' ' . $r->event_time;
				$nestedData['event_type_and_package'] = $r->package_name . ' - ' . $r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
				$nestedData['customer_fullname'] = ucwords($r->customer_fullname);
				$nestedData['event_status'] = '<span title="Danger" class="badge bg-success">COMPLETED</span>';
				$nestedData['payment_status'] = $r->payment_status;
				$nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
				$nestedData['action'] = '
                    <button name="show" id="show-completed-planner" data-id="' . $r->id . '" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-completed-planner" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
				';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"			    => intval($request->input('draw')),
			"recordsTotal"	    => intval($totalData),
			"recordsFiltered"   => intval($totalFiltered),
			"data"			    => $data
		);

		//return the data in json response
		return response()->json($json_data);
	}

	public function fetchInActivePlanner(Request $request)
	{
		ini_set('max_execution_time', 100);
		//column list in the table Prpducts
		$columns = array(
			0 => 'event_name',
			1 => 'event_venue',
			2 => 'no_of_guests',
			3 => 'event_date',
			4 => 'event_time',
			5 => 'created_at',
			6 => 'action'
		);

		//get the total number of data in Category table
		$totalData = Planner::onlyTrashed()->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the Category datatable
		if (empty($request->input('search.value'))) {
			//get all the category data
			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where([
					['planners.deleted_at', '<>', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data
			$totalFiltered = Planner::onlyTrashed()->count();
		} else {
			$search = $request->input('search.value');

			$posts = DB::table('planners')
				->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
				->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
				->leftJoin('payment_statuses', 'planners.payment_status_id', '=', 'payment_statuses.id')
				->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name', 'payment_statuses.name as payment_status')
				->where(function ($query) use ($search) {
					$query->where('planners.event_name', 'like', '%' . $search . '%')
						->orWhere('planners.event_venue', 'like', "%{$search}%")
						->orWhere('planners.no_of_guests', 'like', "%{$search}%")
						->orWhere('planners.event_date', 'like', "%{$search}%")
						->orWhere('planners.event_time', 'like', "%{$search}%")
						->orWhere('planners.status', 'like', "%{$search}%")
						->orWhere('planners.customer_fullname', 'like', "%{$search}%")
						->orWhere('main_packages.name', 'like', "%{$search}%")
						->orWhere('packages.name', 'like', "%{$search}%")
						->orWhere('planners.created_at', 'like', "%{$search}%");
				})
				->where([
					['planners.deleted_at', '<>', null]
				])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::onlyTrashed()->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$status = "";
				if ($r->status == 'completed') {
					$status = '<span title="Danger" class="badge bg-success">COMPLETED</span>';
				} else if ($r->status == 'on-going') {
					$status = '<span title="Danger" class="badge bg-primary">ON-GOING</span>';
				} else {
					$status =  '<span title="Danger" class="badge bg-info">PENDING</span>';
				}
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
				$nestedData['event_date_and_time'] = $r->event_date . ' ' . $r->event_time;
				$nestedData['event_type_and_package'] = $r->package_name . ' - ' . $r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
				$nestedData['event_venue'] = $r->no_of_guests;
				$nestedData['customer_fullname'] = ucwords($r->customer_fullname);
				$nestedData['event_status'] = $status;
				$nestedData['payment_status'] = $r->payment_status;
				$nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
				$nestedData['action'] = '
					<button name="restore" id="restore-planner" data-id="' . $r->id . '" class="btn btn-success btn-xs">Restore</button>
				';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"			    => intval($request->input('draw')),
			"recordsTotal"	    => intval($totalData),
			"recordsFiltered"   => intval($totalFiltered),
			"data"			    => $data
		);

		//return the data in json response
		return response()->json($json_data);
	}
}
