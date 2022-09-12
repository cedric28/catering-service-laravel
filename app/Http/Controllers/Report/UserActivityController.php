<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlannerStaffing;
use Validator;
use Carbon\Carbon;

class UserActivityController extends Controller
{
    public function usersActiveTracker(Request $request)
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

        // $attendance = new PlannerStaffing();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $attendance  = \DB::table('planner_staffings')
                            ->select(
                                    'user_id',
                                    \DB::raw("COUNT(task_date) as total_days"),
                                    \DB::raw("COUNT(( CASE WHEN attendance = 'active' THEN 1 END )) as present"),
                                    'users.name as employee_name'
                            )->leftJoin('users', 'users.id', '=', 'planner_staffings.user_id')
                            ->groupBy('planner_staffings.user_id')
                            ->groupBy('users.name');
                            
    
     
        if($startDate) {
            $attendance = $attendance->whereMonth('task_date', '>=', $startDate)->whereYear('task_date','>=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date','>=', $yearNow);
        }

        if($endDate) {
            $attendance = $attendance->whereMonth('task_date', '<=', $endDate)->whereYear('task_date','<=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date','<=', $yearNow);
        }
    
        $attendance = $attendance->orderBy('employee_name','ASC')->paginate(10);
    
        return view("user_activities.index",[
            'attendance' => $attendance
        ]);
    }
}
