<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Planner;
use Illuminate\Support\Facades\DB;

class PlannerFetchController extends Controller
{
    public function fetchPendingPlanner(Request $request)
    {
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
		$totalData = Planner::where('status','pending')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');
		
		//check if user search for a value in the Category datatable
		if(empty($request->input('search.value'))){
			//get all the category data
			$posts = DB::table('planners')
                    ->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
                    ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                    ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
                    ->where([
                        ['planners.status','pending'],
                        ['planners.deleted_at', '=', null]
                    ])
                    ->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			
			//total number of filtered data
			$totalFiltered = Planner::where('status','pending')->count();
		}else{
            $search = $request->input('search.value');
            
			$posts = DB::table('planners')
                        ->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
                        ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                        ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
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
                            ['planners.status','pending'],
                            ['planners.deleted_at', '=', null]
                        ])
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::where('status','pending')->count();
		}		
					
		
		$data = array();
		
		if($posts){
			//loop posts collection to transfer in another array $nestedData
			foreach($posts as $r){
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
                $nestedData['event_date_and_time'] = $r->event_date.' '.$r->event_time;
                $nestedData['event_type_and_package'] = $r->package_name.' - '.$r->main_package_name;
                $nestedData['no_of_guests'] = $r->no_of_guests;
                $nestedData['customer_fullname'] = $r->customer_fullname;
                $nestedData['event_status'] = $r->status;
				$nestedData['created_at'] = date('d-m-Y',strtotime($r->created_at));
                $nestedData['action'] = '
                    <button name="show" id="show-pending-planner" data-id="'.$r->id.'" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-pending-planner" data-id="'.$r->id.'" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete-pending-planner" data-id="'.$r->id.'" class="btn btn-danger btn-xs">Delete</button>
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
		$totalData = Planner::where('status','on-going')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');
		
		//check if user search for a value in the Category datatable
		if(empty($request->input('search.value'))){
			//get all the category data
			$posts = DB::table('planners')
					->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
                    ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                    ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
                    ->where([
						['planners.status','=','on-going'],
                        ['planners.deleted_at', '=', null]
                    ])
                    ->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			
			//total number of filtered data
			$totalFiltered = Planner::where('status','on-going')->count();
		}else{
            $search = $request->input('search.value');
            
			$posts = DB::table('planners')
                        ->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
                        ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                        ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
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
                            ['planners.status','=','on-going'],
                            ['planners.deleted_at', '=', null]
                        ])
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::where('status','on-going')->count();
		}		
					
		
		$data = array();
		
		if($posts){
			//loop posts collection to transfer in another array $nestedData
			foreach($posts as $r){
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
                $nestedData['event_date_and_time'] = $r->event_date.' '.$r->event_time;
                $nestedData['event_type_and_package'] = $r->package_name.' - '.$r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
                $nestedData['customer_fullname'] = $r->customer_fullname;
                $nestedData['event_status'] = $r->status;
				$nestedData['created_at'] = date('d-m-Y',strtotime($r->created_at));
                $nestedData['action'] = '
                    <button name="show" id="show-on-going-planner" data-id="'.$r->id.'" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-on-going-planner" data-id="'.$r->id.'" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete-on-going-planner" data-id="'.$r->id.'" class="btn btn-danger btn-xs">Delete</button>
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
		$totalData = Planner::where('status','done')->count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');
		
		//check if user search for a value in the Category datatable
		if(empty($request->input('search.value'))){
			//get all the category data
			$posts = DB::table('planners')
					->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
                    ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                    ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
                    ->where([
                        ['planners.status','done'],
                        ['planners.deleted_at', '=', null]
                    ])
                    ->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			
			//total number of filtered data
			$totalFiltered = Planner::where('status','done')->count();
		}else{
            $search = $request->input('search.value');
            
			$posts = DB::table('planners')
                        ->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
                        ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                        ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
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
                            ['planners.status','done'],
                            ['planners.deleted_at', '=', null]
                        ])
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();

			//total number of filtered data matching the search value request in the Category table	
			$totalFiltered = Planner::where('status','done')->count();
		}		
					
		
		$data = array();
		
		if($posts){
			//loop posts collection to transfer in another array $nestedData
			foreach($posts as $r){
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
                $nestedData['event_date_and_time'] = $r->event_date.' '.$r->event_time;
                $nestedData['event_type_and_package'] = $r->package_name.' - '.$r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
                $nestedData['customer_fullname'] = $r->customer_fullname;
                $nestedData['event_status'] = $r->status;
				$nestedData['created_at'] = date('d-m-Y',strtotime($r->created_at));
                $nestedData['action'] = '
                    <button name="show" id="show-done-planner" data-id="'.$r->id.'" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit-done-planner" data-id="'.$r->id.'" class="btn btn-warning btn-xs">Edit</button>
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
		if(empty($request->input('search.value'))){
			//get all the category data
			$posts = DB::table('planners')
					->leftJoin('packages', 'planners.package_id', '=', 'packages.id')
                    ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                    ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
                    ->where([
                        ['planners.deleted_at', '<>', null]
                    ])
                    ->offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			
			//total number of filtered data
			$totalFiltered = Planner::onlyTrashed()->count();
		}else{
            $search = $request->input('search.value');
            
			$posts = DB::table('planners')
                        ->leftJoin('packages', 'planners.package_id', '=', 'planners.id')
                        ->leftJoin('main_packages', 'packages.main_package_id', '=', 'main_packages.id')
                        ->select('planners.*', 'packages.name as package_name', 'main_packages.name as main_package_name')
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
		
		if($posts){
			//loop posts collection to transfer in another array $nestedData
			foreach($posts as $r){
				$nestedData['event_name'] = $r->event_name;
				$nestedData['event_venue'] = $r->event_venue;
                $nestedData['event_date_and_time'] = $r->event_date.' '.$r->event_time;
                $nestedData['event_type_and_package'] = $r->package_name.' - '.$r->main_package_name;
				$nestedData['no_of_guests'] = $r->no_of_guests;
                $nestedData['event_venue'] = $r->no_of_guests;
                $nestedData['customer_fullname'] = $r->customer_fullname;
                $nestedData['event_status'] = $r->status;
				$nestedData['created_at'] = date('d-m-Y',strtotime($r->created_at));
                $nestedData['action'] = '
					<button name="restore" id="restore-planner" data-id="'.$r->id.'" class="btn btn-success btn-xs">Restore</button>
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

	public function fetchPlannerTask(Request $request)
    {
	}

	public function fetchPlannerEquipment(Request $request)
    {
	}

	public function fetchPlannerOther(Request $request)
    {
	}

	public function fetchPlannerStaffing(Request $request)
    {
	}
}
