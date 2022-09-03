<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\InventoryCategory;

class InventoryFetchController extends Controller
{
    public function fetchInventory(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'description',
            2 => 'quantity',
            3 => 'quantity_in_use',
            4 => 'quantity_available',
            5 => 'created_at',
            6 => 'action'
        );

        //get the total number of data in Category table
        $totalData = Inventory::count();
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

            $productName = $request->input('columns.0.search.value');
            $productCategory = $request->input('columns.1.search.value');
            $productQuantity = $request->input('columns.2.search.value');
            $productQuantityAvailable = $request->input('columns.3.search.value');
            $productQuantityInUse = $request->input('columns.4.search.value');
            $productCreatedAt = $request->input('columns.5.search.value');

            $posts = Inventory::where('name', 'like', "%{$productName}%")
                ->where('quantity', 'like', "%{$productQuantity}%")
                ->where('quantity_in_use', 'like', "%{$productQuantityInUse}%")
                ->where('quantity_available', 'like', "%{$productQuantityAvailable}%")
                ->where('created_at', 'like', "%{$productCreatedAt}%")
                ->whereHas('inventory_category', function ($query) use ($productCategory) {
                    $query->where('name', 'like', "%{$productCategory}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Inventory::where('name', 'like', "%{$productName}%")
            ->where('quantity', 'like', "%{$productQuantity}%")
            ->where('quantity_in_use', 'like', "%{$productQuantityInUse}%")
            ->where('quantity_available', 'like', "%{$productQuantityAvailable}%")
            ->where('created_at', 'like', "%{$productCreatedAt}%")
            ->whereHas('inventory_category', function ($query) use ($productCategory) {
                $query->where('name', 'like', "%{$productCategory}%");
            })->count();
        } else {
            $search = $request->input('search.value');

            $posts = Inventory::where('name', 'like', "%{$search}%")
                ->orWhere('quantity', 'like', "%{$search}%")
                ->orWhere('quantity_in_use', 'like', "%{$search}%")
                ->orWhere('quantity_available', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('inventory_category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = Inventory::where('name', 'like', "%{$search}%")
                ->orWhere('quantity', 'like', "%{$search}%")
                ->orWhere('quantity_in_use', 'like', "%{$search}%")
                ->orWhere('quantity_available', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('inventory_category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['category'] = $r->inventory_category->name;
                $nestedData['quantity'] = $r->quantity;
                $nestedData['quantity_in_use'] = $r->quantity_in_use;
                $nestedData['quantity_available'] = $r->quantity_available;
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

    public function fetchInventoryCategory(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = InventoryCategory::count();
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
            $posts = InventoryCategory::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = InventoryCategory::count();
        } else {
            $search = $request->input('search.value');

            $posts = InventoryCategory::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = InventoryCategory::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
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
}
