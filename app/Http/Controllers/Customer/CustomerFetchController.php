<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Planner;
use Illuminate\Support\Facades\DB;

class CustomerFetchController extends Controller
{
    public function fetchCustomer(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isHeadStaffOrAdmin");

        //column list in the table Prpducts
        $columns = array(
            0 => 'customer_firstname',
            1 => 'customer_lastname',
            2 => 'contact_number',
            3 => 'created_at',
            4 => 'action'
        );

        $totalData = Customer::count();
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
            $posts = Customer::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Customer::count();
        } else {
            $search = $request->input('search.value');

            $posts = Customer::where('customer_firstname', 'like', "%{$search}%")
                ->orWhere('customer_lastname', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();


            $totalFiltered = Customer::where('customer_firstname', 'like', "%{$search}%")
                ->orWhere('customer_lastname', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['customer_firstname'] = $r->customer_firstname;
                $nestedData['customer_lastname'] = $r->customer_lastname;
                $nestedData['contact_number'] =  $r->contact_number;
                $nestedData['created_at'] = date('m-d-Y', strtotime($r->created_at));
                $nestedData['action'] = '
					<button name="edit" id="edit" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
				';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"                => $data
        );

        //return the data in json response
        return response()->json($json_data);
    }

    public function fetchInactiveCustomer(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isHeadStaffOrAdmin");

        //column list in the table Prpducts
        $columns = array(
            0 => 'customer_firstname',
            1 => 'customer_lastname',
            2 => 'contact_number',
            3 => 'created_at',
            4 => 'action'
        );

        $totalData = Customer::onlyTrashed()->count();
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
            $posts = Customer::onlyTrashed()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Customer::onlyTrashed()->count();
        } else {
            $search = $request->input('search.value');

            $posts = Customer::onlyTrashed()->where('customer_firstname', 'like', "%{$search}%")
                ->orWhere('customer_lastname', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();


            $totalFiltered = Customer::onlyTrashed()->where('customer_firstname', 'like', "%{$search}%")
                ->orWhere('customer_lastname', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['customer_firstname'] = $r->customer_firstname;
                $nestedData['customer_lastname'] = $r->customer_lastname;
                $nestedData['contact_number'] =  $r->contact_number;
                $nestedData['created_at'] = date('m-d-Y', strtotime($r->created_at));
                $nestedData['action'] = '
                <button name="show" id="restore-customer" data-id="' . $r->id . '" class="btn btn-success btn-sm">Restore</button>
                 ';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"     => intval($totalFiltered),
            "data"                => $data
        );

        //return the data in json response
        return response()->json($json_data);
    }


    public function fetchCustomerPlanner(Request $request)
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
        $totalData = Planner::where('customer_id', $request->customer_id)->count();
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
                    ['planners.customer_id', $request->customer_id],
                    ['planners.deleted_at', '=', null]
                ])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Planner::where('customer_id', $request->customer_id)->count();
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
                        ->orWhere('main_packages.name', 'like', "%{$search}%")
                        ->orWhere('packages.name', 'like', "%{$search}%")
                        ->orWhere('planners.created_at', 'like', "%{$search}%");
                })
                ->where([
                    ['planners.customer_id', $request->customer_id],
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
                        ->orWhere('main_packages.name', 'like', "%{$search}%")
                        ->orWhere('packages.name', 'like', "%{$search}%")
                        ->orWhere('planners.created_at', 'like', "%{$search}%");
                })
                ->where([
                    ['planners.customer_id', $request->customer_id],
                    ['planners.deleted_at', '=', null]
                ])->count();
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
                    $status =  '<span title="Danger" class="badge bg-info">UPCOMING</span>';
                }
                $nestedData['event_name'] = $r->event_name;
                $nestedData['event_status'] = $status;
                $nestedData['event_date_and_time'] = $r->event_date . ' ' . $r->event_time;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"                => $data
        );

        //return the data in json response
        return response()->json($json_data);
    }
}
