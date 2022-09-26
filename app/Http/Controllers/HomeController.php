<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Planner;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();
        $yearNow =  $now->year;
        $monthNow = $now->month;
        $sales = new Payment();
        $sales = $sales->whereYear('created_at', '>=', $yearNow)->whereYear('created_at', '<=', $yearNow);
        $salesPerMonth = $sales->selectRaw('month(created_at) as month, SUM(payment_price) as total_sales')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
        
        $filtered_collection = $salesPerMonth->filter(function ($item) use ($monthNow) {
            return $item->month == $monthNow;
        })->values();

        $monthlySales = count($filtered_collection) > 0 ? Str::currency($filtered_collection[0]->total_sales) : Str::currency(0) ;
        $users = User::count();
        $planners = Planner::where('status', '=', 'on-going')
        ->orWhere('status', '=', 'completed')->get();
        $plannerOnGoing = Planner::where('status','on-going')->count();
        $plannerCompleted = Planner::where('status','completed')->count();
        
        return view('home',[
            'totalUsers' => $users,
            'planners' => $planners,
            'plannerOnGoing' => $plannerOnGoing,
            'monthlySales' => $monthlySales,
            'plannerCompleted' => $plannerCompleted
        ]);
    }
    public function showPlannerDetails(Request $request)
    {

    }
}
