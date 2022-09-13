<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Foods;
use App\DishCategory;

class FoodFetchController extends Controller
{
    public function fetchFood(Request $request)
    {
        ini_set('max_execution_time', 600);
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = Foods::count();
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
            $posts = Foods::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Foods::count();
        } else {
            $search = $request->input('search.value');

            $posts = Foods::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = Foods::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['food_category_name'] = $r->category->name;
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

    public function fetchFoodCategory(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'name',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = Category::count();
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
            $posts = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Category::count();
        } else {
            $search = $request->input('search.value');

            $posts = Category::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('dish_category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = Category::where('name', 'like', "%{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhereHas('dish_category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->name;
                $nestedData['dish_category_name'] = $r->dish_category->name;
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
