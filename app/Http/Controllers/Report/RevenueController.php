<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Payment;
use Validator;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function revenueMonthly(Request $request)
    {
        $messages = [
            'lte' => 'The :attribute year must be less than end date.',
        ];
        //validate request value
        $validator = Validator::make($request->all(), [
            'end_date' => '',
            'start_date' => 'lte:end_date',
       ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        
        $now = Carbon::now();
        $yearNow =  $now->year;

        $sales = new Payment();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if($startDate) {
            $sales = $sales->whereMonth('created_at', '>=', $startDate)->whereYear('created_at','>=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at','>=', $yearNow);
        }

        if($endDate) {
            $sales = $sales->whereMonth('created_at', '<=', $endDate)->whereYear('created_at','<=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at','<=', $yearNow);
        }
    
        $sales = $sales->oldest()->paginate(10);

        $totalPrice = $sales->sum('payment_price');
    
        return view("revenue.index",[
            'sales' => $sales,
            'totalPrice' => $totalPrice
        ]);
    }
}
