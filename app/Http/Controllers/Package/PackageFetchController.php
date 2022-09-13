<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use App\PackageTask;
use App\PackageMenu;
use App\PackageEquipments;
use App\PackageOther;
use Illuminate\Support\Str;

class PackageFetchController extends Controller
{
    public function fetchPackage(Request $request)
    {
        ini_set('max_execution_time', 100);
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'package_pax',
            2 => 'package_price',
            3 => 'created_at',
            4 => 'action'
        );

        //get the total number of data in Category table
        $totalData = Package::count();
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
            $posts = Package::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Package::count();
        } else {
            $search = $request->input('search.value');

            $posts = Package::where('name', 'like', "%{$search}%")
                ->orWhere('package_pax', 'like', "%{$search}%")
                ->orWhere('package_price', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('main_package', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = Package::where('name', 'like', "%{$search}%")
                ->orWhere('package_pax', 'like', "%{$search}%")
                ->orWhere('package_price', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('main_package', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['package_pax'] = Str::number_comma($r->package_pax);
                $nestedData['package_price'] = Str::currency($r->package_price);
                $nestedData['main_package_name'] = $r->main_package->name;
                $nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
                $nestedData['action'] = '
                    <button name="show" id="show" data-id="' . $r->id . '" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
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

    public function fetchPackageTask(Request $request)
    {
        ini_set('max_execution_time', 100);
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PackageTask::where('package_id', $request->package_id)->count();
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
            $posts = PackageTask::where('package_id', $request->package_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PackageTask::where('package_id', $request->package_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PackageTask::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhere('name', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PackageTask::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhere('name', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
                if ($request->is_show == 0) {
                    $nestedData['action'] = '
                        <button name="edit" id="edit" data-name="' . $r->name . '" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
                        <button name="delete" id="delete-task-package" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
                    ';
                }
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

    public function fetchPackageFood(Request $request)
    {
        ini_set('max_execution_time', 100);
        //column list in the table Prpducts
        $columns = array(
            0 => 'category_id',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PackageMenu::where('package_id', $request->package_id)->count();
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
            $posts = PackageMenu::where('package_id', $request->package_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PackageMenu::where('package_id', $request->package_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PackageMenu::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_food_category', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('created_at', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PackageMenu::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_food_category', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('created_at', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->package_food_category->name;
                $nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
                if ($request->is_show == 0) {
                    $nestedData['action'] = '
                        <button name="edit" id="edit-food-package" data-category-id="' . $r->category_id . '" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
                        <button name="delete" id="delete-food-package" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
                    ';
                }
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

    public function fetchPackageEquipment(Request $request)
    {
        ini_set('max_execution_time', 100);
        //column list in the table Prpducts
        $columns = array(
            0 => 'inventory_id',
            1 => 'quantity',
            2 => 'created_at',
            3 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PackageEquipments::where('package_id', $request->package_id)->count();
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
            $posts = PackageEquipments::where('package_id', $request->package_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PackageEquipments::where('package_id', $request->package_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PackageEquipments::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_equipment', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('quantity', 'like', "%{$search}%")
                        ->orWhere('created_at', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PackageEquipments::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_equipment', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                        ->orWhere('quantity', 'like', "%{$search}%")
                        ->orWhere('created_at', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->package_equipment->name;
                $nestedData['quantity'] = $r->quantity;
                $nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
                if ($request->is_show == 0) {
                    // <button name="edit" id="edit-equipment-package" data-quantity="' . $r->quantity . '"  data-inventory-id="' . $r->inventory_id . '" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
                    $nestedData['action'] = '
                        <button name="delete" id="delete-equipment-package" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
                    ';
                }
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

    public function fetchPackageOther(Request $request)
    {
        ini_set('max_execution_time', 100);
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'service_price',
            2 => 'created_at',
            3 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PackageOther::where('package_id', $request->package_id)->count();
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
            $posts = PackageOther::where('package_id', $request->package_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PackageOther::where('package_id', $request->package_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PackageOther::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('service_price', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PackageOther::where('package_id', $request->package_id)
                ->where(function ($query) use ($search) {
                    $query->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('service_price', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['service_price'] = Str::currency($r->service_price);
                $nestedData['created_at'] = date('d-m-Y', strtotime($r->created_at));
                if ($request->is_show == 0) {
                    $nestedData['action'] = '
                    <button name="edit" id="edit-other-package" data-price="' . $r->service_price . '" data-name="' . $r->name . '" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
                    <button name="delete" id="delete-other-package" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Delete</button>
                    ';
                }

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
