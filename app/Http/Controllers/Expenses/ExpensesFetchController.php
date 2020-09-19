<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expenses;

class ExpensesFetchController extends Controller
{
    public function fetchExpense(Request $request)
    {
		//column list in the table Prpducts
        $columns = array(
			0 => 'category_id',
            1 => 'amount',
            2 => 'entry_date',
			3 => 'created_at',
			4 => 'action'
		);
		
		$totalData = Expenses::count();
		//total number of data that will show in the datatable default 10
		$limit = $request->input('length');
		//start number for pagination ,default 0
		$start = $request->input('start');
		//order list of the column
		$order = $columns[$request->input('order.0.column')];
		//order by ,default asc 
		$dir = $request->input('order.0.dir');
		
		//check if user search for a value in the product datatable
		if(empty($request->input('search.value'))){
			//get all the product data
			$posts = Expenses::offset($start)
					->limit($limit)
					->orderBy($order,$dir)
					->get();
			
			//total number of filtered data
			$totalFiltered = Expenses::count();
		}else{
            $search = $request->input('search.value');
            
			$posts = Expenses::whereHas('category', function ($query) use($search) {
								$query->where('title', 'like', "%{$search}%");
							})
							->orwhere('amount', 'like', "%{$search}%")
                            ->orWhere('entry_date','like',"%{$search}%")
							->orWhere('created_at','like',"%{$search}%")
							->offset($start)
							->limit($limit)
							->orderBy($order, $dir)
							->get();


			$totalFiltered = Expenses::whereHas('category', function ($query) use($search) {
								$query->where('title', 'like', "%{$search}%");
							})
							->orwhere('amount', 'like', "%{$search}%")
                            ->orWhere('entry_date','like',"%{$search}%")
							->count();
		}		
					
		
		$data = array();
		
		if($posts){
			//loop posts collection to transfer in another array $nestedData
			foreach($posts as $r){
				$nestedData['id'] = $r->id;
				$nestedData['category'] = $r->category->title;
                $nestedData['amount'] = $r->amount;
                $nestedData['entry_date'] =  date('m-d-Y',strtotime($r->entry_date));
				$nestedData['created_at'] = date('m-d-Y',strtotime($r->created_at));
                $nestedData['action'] = '
                    <button name="show" id="show" data-id="'.$r->id.'" class="btn btn-primary btn-xs">Show</button>
					<button name="edit" id="edit" data-id="'.$r->id.'" class="btn btn-warning btn-xs">Edit</button>
					<button name="delete" id="delete" data-id="'.$r->id.'" class="btn btn-danger btn-xs">Delete</button>
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
