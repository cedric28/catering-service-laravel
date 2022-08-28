<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Planner;

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

        $users = User::count();
        $planners = Planner::where('status', '=', 'on-going')
        ->orWhere('status', '=', 'done')->get();
        $plannerPendings = Planner::where('status','pending')->count();
        
        return view('home',[
            'totalUsers' => $users,
            'planners' => $planners,
            'plannerPendings' => $plannerPendings
        ]);
    }
}
