<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ExpenseChart;
use App\User;
use App\Expenses;

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
        $expenses = Expenses::all();

        $tempArrayExpenses = [];
        $tempArray = [];
       
        foreach ($expenses as $key => $value) {
         
            $tempArrayExpenses[] = [
                "category" => $value->category->title,
                "amount" => $value->amount,
                "entry" =>  date("M j Y",strtotime($value->entry_date)),
            ];
        }

        $groupByCategory = $this->_group_by($tempArrayExpenses, "category");
        
        $pieGraphLabels = [];
        $pieGraphTotal  = [];
        foreach ($groupByCategory as $key => $categoryId) {
            $total = 0;
          
            foreach ($categoryId as $key => $row) {
                $total += $row['amount'];
            }

            $tempArray[] = [
                "category" => $row["category"],
                "total" => $total,
                
            ];
            $pieGraphLabels[] = $row['category'];
            $pieGraphTotal[] = $total;
        }

        $pieCategoriesExpenses = $this->donut_chart($pieGraphLabels, $pieGraphTotal);

       
        $user = User::count();

        return view('home',[
            "user" => $user,
            'pieCategoriesExpenses' => $pieCategoriesExpenses,
            'expensesArray' => $tempArray
        ]);
    }

    public function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


    public function donut_chart($projects, $values){
      
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1)",
            "rgba(255, 205, 86, 1)",
            "rgba(51,105,232, 1)",
            "rgba(244,67,54, 1)",
            "rgba(34,198,246, 1)",
            "rgba(153, 102, 255, 1)",
            "rgba(255, 159, 64, 1)",
            "rgba(233,30,99, 1)",
            "rgba(205,220,57, 1)"
        ];

        $distributionChart = new ExpenseChart;
        $distributionChart->options([
            
        ]);
        $distributionChart->minimalist(true);  
        $distributionChart->labels($projects);
        $distributionChart->dataset('Total Expenses', 'doughnut', $values)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return $distributionChart;
    }
}
