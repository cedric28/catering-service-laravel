<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\PlannerStaffing;
use App\PlannerTaskStaff;
use Illuminate\Support\Facades\DB;

class UserFetchController extends Controller
{
	public function fetchUser(Request $request)
	{
		//prevent other user to access to this page
		$this->authorize("isAdmin");

		//column list in the table Prpducts
		$columns = array(
			0 => 'name',
			1 => 'email',
			2 => 'role_id',
			3 => 'created_at',
			4 => 'action'
		);

		$totalData = User::whereIn('role_id',[2,3])->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the product datatable
		if (empty($request->input('search.value'))) {
			//get all the product data
			$posts = User::whereIn('role_id',[2,3])
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();

			//total number of filtered data
			$totalFiltered = User::whereIn('role_id',[2,3])->count();
		} else {
			$search = $request->input('search.value');

			$posts = User::whereHas('role', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%")
							->whereIn('id', [2,3]);
				})
				->whereHas('job_type', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%");
				})
				->orWhere(function($query) use ($search){
					$query->where('name', 'like', "%{$search}%")
						  ->whereIn('role_id',[2,3]);
				})
				->orWhere('email', 'like', "%{$search}%")
				->orWhere('created_at', 'like', "%{$search}%")
				->offset($start)
				->limit($limit)
				->orderBy($order, $dir)
				->get();


			$totalFiltered = User::whereHas('role', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%")
							->whereIn('id', [2,3]);
				})
				->whereHas('job_type', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%");
				})
				->orWhere(function($query) use ($search){
					$query->where('name', 'like', "%{$search}%")
						  ->whereIn('role_id',[2,3]);
				})
				->orWhere('email', 'like', "%{$search}%")
				->orWhere('created_at', 'like', "%{$search}%")
				->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$task = '<span title="Danger" class="badge bg-info">IDLE</span>';
				if($r->job_type_id == 2 || $r->job_type_id == 1){
					$tasksHeadStaff = PlannerTaskStaff::where([
						['task_date',date('Y-m-d') ],
						['user_id',$r->id ],
					])->get();
					if(count($tasksHeadStaff) > 0){
						$task = '<span title="Danger" class="badge bg-success">ON-TASK</span>';
					}
				} else {
					$taskStaffing = PlannerStaffing::where([
						['task_date','=', date('Y-m-d') ],
						['user_id','=', $r->id ],
						['attendance','=', 'active' ],
					])->get();
					if(count($taskStaffing) > 0){
						$task = '<span title="Danger" class="badge bg-success">ON-TASK</span>';
					}
				}
				$nestedData['id'] = $r->id;
				$nestedData['name'] = $r->name;
				$nestedData['email'] = $r->email;
				$nestedData['role'] =  $r->role->name;
				$nestedData['job_type'] =  $r->job_type->name;
				$nestedData['status'] =  $task;
				$nestedData['created_at'] = date('m-d-Y', strtotime($r->created_at));
				$nestedData['action'] = '
                    <button name="show" id="show" data-id="' . $r->id . '" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
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

	public function fetchUserTaskStaff(Request $request)
	{
		//prevent other user to access to this page
		$this->authorize("isAdmin");

		//column list in the table Prpducts
		$columns = array(
			0 => 'task_date',
			1 => 'created_at',
			2 => 'action'
		);

		$totalData = PlannerTaskStaff::where('user_id',$request->user_id)->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the product datatable
		if (empty($request->input('search.value'))) {
			//get all the product data
			$posts =  DB::table('planner_task_staff')
						->leftJoin('planner_tasks', 'planner_task_staff.planner_task_id', '=', 'planner_tasks.id')
						->leftJoin('planners', 'planners.id', '=', 'planner_tasks.planner_id')
						->leftJoin('package_tasks', 'package_tasks.id', '=', 'planner_tasks.package_task_id')
						->select('package_tasks.name as task_name','planner_tasks.task_date', 'planner_tasks.task_time', 'planner_tasks.status', 'planners.event_name', 'planners.event_venue')
						->where([
							['planner_task_staff.user_id', $request->user_id],
							['planners.deleted_at', '=', null],
							['package_tasks.deleted_at', '=', null]
						])
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->get();

			//total number of filtered data
			$totalFiltered =  DB::table('planner_task_staff')
								->leftJoin('planner_tasks', 'planner_task_staff.planner_task_id', '=', 'planner_tasks.id')
								->leftJoin('planners', 'planners.id', '=', 'planner_tasks.planner_id')
								->leftJoin('package_tasks', 'package_tasks.id', '=', 'planner_tasks.package_task_id')
								->select('package_tasks.name as task_name','planner_tasks.task_date', 'planner_tasks.task_time', 'planner_tasks.status', 'planners.event_name', 'planners.event_venue')
								->where([
									['planner_task_staff.user_id', $request->user_id],
									['planners.deleted_at', '=', null],
									['package_tasks.deleted_at', '=', null]
								])->count();
		} else {
			$search = $request->input('search.value');

			$posts =  DB::table('planner_task_staff')
							->leftJoin('planner_tasks', 'planner_task_staff.planner_task_id', '=', 'planner_tasks.id')
							->leftJoin('planners', 'planners.id', '=', 'planner_tasks.planner_id')
							->leftJoin('package_tasks', 'package_tasks.id', '=', 'planner_tasks.package_task_id')
							->select('package_tasks.name as task_name','planner_tasks.task_date', 'planner_tasks.task_time', 'planner_tasks.status', 'planners.event_name', 'planners.event_venue')
							->where(function ($query) use ($search) {
								$query->where('planner_tasks.task_date', 'like', '%' . $search . '%')
									->orWhere('planner_tasks.task_time', 'like', "%{$search}%")
									->orWhere('planner_tasks.status', 'like', "%{$search}%")
									->orWhere('planners.event_name', 'like', "%{$search}%")
									->orWhere('planners.event_venue', 'like', "%{$search}%")
									->orWhere('package_tasks.name', 'like', "%{$search}%");
							})
							->where([
								['planner_task_staff.user_id', $request->user_id],
								['planners.deleted_at', '=', null],
								['package_tasks.deleted_at', '=', null]
							])
							->offset($start)
							->limit($limit)
							->orderBy($order, $dir)
							->get();


			$totalFiltered = DB::table('planner_task_staff')
								->leftJoin('planner_tasks', 'planner_task_staff.planner_task_id', '=', 'planner_tasks.id')
								->leftJoin('planners', 'planners.id', '=', 'planner_tasks.planner_id')
								->leftJoin('package_tasks', 'package_tasks.id', '=', 'planner_tasks.package_task_id')
								->select('package_tasks.name as task_name','planner_tasks.task_date', 'planner_tasks.task_time', 'planner_tasks.status', 'planners.event_name', 'planners.event_venue')
								->where(function ($query) use ($search) {
									$query->where('planner_tasks.task_date', 'like', '%' . $search . '%')
										->orWhere('planner_tasks.task_time', 'like', "%{$search}%")
										->orWhere('planner_tasks.status', 'like', "%{$search}%")
										->orWhere('planners.event_name', 'like', "%{$search}%")
										->orWhere('planners.event_venue', 'like', "%{$search}%")
										->orWhere('package_tasks.name', 'like', "%{$search}%");
								})
								->where([
									['planner_task_staff.user_id', $request->user_id],
									['planners.deleted_at', '=', null]
								])->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$status = $r->status == 'finished' ? '<span title="Danger" class="badge bg-success">FINISHED</span>' : '<span title="Danger" class="badge bg-info">PENDING</span>';
				
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_place'] = $r->event_venue;
				$nestedData['task_date_time'] = $r->task_date.' | '.$r->task_time;
				$nestedData['task_name'] = ucwords($r->task_name);
				$nestedData['task_status'] =  $status;
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

	public function fetchUserStaffing(Request $request)
	{
		//prevent other user to access to this page
		$this->authorize("isAdmin");

		//column list in the table Prpducts
		$columns = array(
			0 => 'attendance',
			1 => 'task_date',
			2 => 'created_at',
			3 => 'action'
		);

		$totalData = PlannerStaffing::where('user_id',$request->user_id)->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');

		//check if user search for a value in the product datatable
		if (empty($request->input('search.value'))) {
			//get all the product data
			$posts =  DB::table('planner_staffings')
						->leftJoin('planners', 'planners.id', '=', 'planner_staffings.planner_id')
						->select('planners.event_name','planners.status', 'planners.event_venue','planners.event_date','planners.event_time','planner_staffings.attendance')
						->where([
							['planner_staffings.user_id', $request->user_id],
							['planners.deleted_at', '=', null]
						])
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->get();

			//total number of filtered data
			$totalFiltered =  DB::table('planner_staffings')
								->leftJoin('planners', 'planners.id', '=', 'planner_staffings.planner_id')
								->select('planners.event_name', 'planners.status','planners.event_venue','planners.event_date','planners.event_time','planner_staffings.attendance')
								->where([
									['planner_staffings.user_id', $request->user_id],
									['planners.deleted_at', '=', null]
								])->count();
		} else {
			$search = $request->input('search.value');

			$posts = DB::table('planner_staffings')
						->leftJoin('planners', 'planners.id', '=', 'planner_staffings.planner_id')
						->select('planners.event_name','planners.status', 'planners.event_venue','planners.event_date','planners.event_time','planner_staffings.attendance')
						->where(function ($query) use ($search) {
							$query->where('planners.event_name', 'like', '%' . $search . '%')
								->orWhere('planners.event_venue', 'like', "%{$search}%")
								->orWhere('planners.event_date', 'like', "%{$search}%")
								->orWhere('planners.event_time', 'like', "%{$search}%")
								->orWhere('planners.status', 'like', "%{$search}%")
								->orWhere('planner_staffings.attendance', 'like', "%{$search}%");
						})
						->where([
							['planner_staffings.user_id', $request->user_id],
							['planners.deleted_at', '=', null]
						])
						->offset($start)
						->limit($limit)
						->orderBy($order, $dir)
						->get();

			$totalFiltered = DB::table('planner_staffings')
								->leftJoin('planners', 'planners.id', '=', 'planner_staffings.planner_id')
								->select('planners.event_name','planners.status', 'planners.event_venue','planners.event_date','planners.event_time','planner_staffings.attendance')
								->where(function ($query) use ($search) {
									$query->where('planners.event_name', 'like', '%' . $search . '%')
										->orWhere('planners.event_venue', 'like', "%{$search}%")
										->orWhere('planners.event_date', 'like', "%{$search}%")
										->orWhere('planners.event_time', 'like', "%{$search}%")
										->orWhere('planners.status', 'like', "%{$search}%")
										->orWhere('planner_staffings.attendance', 'like', "%{$search}%");
								})
								->where([
									['planner_staffings.user_id', $request->user_id],
									['planners.deleted_at', '=', null]
								])->count();
		}


		$data = array();

		if ($posts) {
			//loop posts collection to transfer in another array $nestedData
			foreach ($posts as $r) {
				$status = "";
				if($r->status == 'done'){
					$status = '<span title="Danger" class="badge bg-success">DONE</span>';
				} else if ($r->status == 'on-going'){
					$status = '<span title="Danger" class="badge bg-primary">ON-GOING</span>';
				} else {
					$status =  '<span title="Danger" class="badge bg-info">PENDING</span>';
				}
				$attendance= $r->attendance == 'inactive' ? '<span title="Danger" class="badge bg-warning">INACTIVE</span>' : '<span title="Danger" class="badge bg-success">ACTIVE</span>';
				
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_place'] = $r->event_venue;
				$nestedData['event_date_time'] =  $r->event_date.' | '.$r->event_time;
				$nestedData['event_status'] =  $status;
				$nestedData['attendance'] =  $attendance;
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
