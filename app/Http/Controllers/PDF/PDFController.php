<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Planner;
use App\Payment;
use App\PlannerTimeTable;
use App\PlannerOther;
use App\PackageOther;
use App\PackageMenu;
use App\PlannerStaffing;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Validator;

class PDFController extends Controller
{
    public function generateInvoice(Request $request, $id)
    {
        ini_set('max_execution_time', 100);
        $planner = Planner::find($id);
        $formattedDate = Carbon::now()->format('F d Y');
        $plannerOther = PlannerOther::where('planner_id', $planner->id)->get();

        $servicePriceTotal = 0;
        if (count($plannerOther) > 0) {
            foreach ($plannerOther as $other) {
                $packageOtherServicePrice = PackageOther::select(\DB::raw("SUM(service_price) as price"))->where('id', $other->package_other_id)->get();
                $servicePriceTotal += $packageOtherServicePrice[0]->price;
            }
        }

        $totalBalance = $planner->total_price + $servicePriceTotal;

        // return view("pdf.invoice",[
        //     'planner' => $planner,
        //     'formattedDate' => $formattedDate,
        //     'totalBalance' => $totalBalance,
        //     'plannerOther' => $plannerOther
        // ]);
        view()->share('invoice', $planner);

        $pdf = \PDF::loadView('pdf.invoice',  [
            'planner' => $planner,
            'planner' => $planner,
            'formattedDate' => $formattedDate,
            'totalBalance' => $totalBalance,
            'plannerOther' => $plannerOther
        ]);

        return $pdf->download("INVOICE-" . $planner->or_no . "-" . strtoupper($planner->event_name) . ".pdf");
    }

    public function generateContract(Request $request, $id)
    {
        ini_set('max_execution_time', 100);
        $planner = Planner::find($id);
        $formattedDate = Carbon::parse($planner->event_date)->format('F d Y');
        $timeTable = PlannerTimeTable::where('planner_id', $planner->id)->orderBy('task_time', 'ASC')->get();
        $plannerOther = PlannerOther::where('planner_id', $planner->id)->get();

        $servicePriceTotal = 0;
        if (count($plannerOther) > 0) {
            foreach ($plannerOther as $other) {
                $packageOtherServicePrice = PackageOther::select(\DB::raw("SUM(service_price) as price"))->where('id', $other->package_other_id)->get();
                $servicePriceTotal += $packageOtherServicePrice[0]->price;
            }
        }

        $totalBalance = $planner->total_price + $servicePriceTotal;

        view()->share('contract', $planner);

        $pdf = \PDF::loadView('pdf.contract',  [
            'planner' => $planner,
            'formattedDate' => $formattedDate,
            'timeTable' => $timeTable,
            'servicePriceTotal' => Str::currency($totalBalance)
        ]);

        return $pdf->download("CONTRACT-" . $planner->or_no . "-" . strtoupper($planner->event_name) . ".pdf");
    }

    public function generateMonthlyRevenue(Request $request)
    {
        ini_set('max_execution_time', 100);
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
        $formattedDate = Carbon::now()->format('F d Y');

        $sales = new Payment();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if ($startDate) {
            $sales = $sales->whereMonth('created_at', '>=', $startDate)->whereYear('created_at', '>=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at', '>=', $yearNow);
        }

        if ($endDate) {
            $sales = $sales->whereMonth('created_at', '<=', $endDate)->whereYear('created_at', '<=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at', '<=', $yearNow);
        }

        $sales = $sales->latest()->get();

        $first = $sales->first();
        $last = $sales->last();

        $totalPrice = $sales->sum('payment_price');
        view()->share('sales', $sales);

        $pdf = \PDF::loadView('pdf.monthly_revenue', [
            'sales' => $sales,
            'totalPrice' => $totalPrice,
            'formattedDate' => $formattedDate,
            "startDate" => Carbon::parse($first->created_at ?? Carbon::now())->format('M d, Y'),
            "endDate" => Carbon::parse($last->created_at ?? Carbon::now())->format('M d, Y')
        ]);
        // return view("pdf.monthly_revenue",[
        //     'sales' => $sales,
        //     'totalPrice' => $totalPrice,
        //     'formattedDate' => $formattedDate
        // ]);

        return $pdf->download("Monthly-Sales-" . Carbon::now()->format('m-d-Y') . ".pdf");
    }


    public function printMonthlyRevenue(Request $request)
    {
        ini_set('max_execution_time', 100);
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
        $formattedDate = Carbon::now()->format('F d Y');

        $sales = new Payment();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if ($startDate) {
            $sales = $sales->whereMonth('created_at', '>=', $startDate)->whereYear('created_at', '>=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at', '>=', $yearNow);
        }

        if ($endDate) {
            $sales = $sales->whereMonth('created_at', '<=', $endDate)->whereYear('created_at', '<=', $yearNow);
        } else {
            $sales = $sales->whereYear('created_at', '<=', $yearNow);
        }

        $sales = $sales->latest()->get();

        $first = $sales->first();
        $last = $sales->last();

        $totalPrice = $sales->sum('payment_price');

        return view("pdf.monthly_revenue", [
            'sales' => $sales,
            'totalPrice' => $totalPrice,
            'formattedDate' => $formattedDate,
            "startDate" => Carbon::parse($first->created_at ?? Carbon::now())->format('M d, Y'),
            "endDate" => Carbon::parse($last->created_at ?? Carbon::now())->format('M d, Y')
        ]);
    }


    public function generateYearlyRevenue(Request $request)
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
        $formattedDate = Carbon::now()->format('F d Y');

        $sales = new Payment();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if ($startDate) {
            $sales = $sales->whereYear('created_at', '>=', $request->start_date);
        }
        if ($endDate) {
            $sales = $sales->whereYear('created_at', '<=', $request->end_date);
        }

        $sales = $sales->latest()->get();

        $totalPrice = $sales->sum('payment_price');
        view()->share('sales', $sales);

        $pdf = \PDF::loadView('pdf.monthly_revenue', [
            'sales' => $sales,
            'totalPrice' => $totalPrice,
            'formattedDate' => $formattedDate,
            "startDate" => $startDate,
            "endDate" => $endDate
        ]);
        // return view("pdf.monthly_revenue",[
        //     'sales' => $sales,
        //     'totalPrice' => $totalPrice,
        //     'formattedDate' => $formattedDate
        // ]);

        return $pdf->download("Yearly-Sales-" . Carbon::now()->format('m-d-Y') . ".pdf");
    }


    public function printYearlyRevenue(Request $request)
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
        $formattedDate = Carbon::now()->format('F d Y');

        $sales = new Payment();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if ($startDate) {
            $sales = $sales->whereYear('created_at', '>=', $request->start_date);
        }
        if ($endDate) {
            $sales = $sales->whereYear('created_at', '<=', $request->end_date);
        }

        $sales = $sales->latest()->get();

        $totalPrice = $sales->sum('payment_price');

        return view("pdf.yearly_revenue", [
            'sales' => $sales,
            'totalPrice' => $totalPrice,
            'formattedDate' => $formattedDate,
            "startDate" => $startDate,
            "endDate" => $endDate
        ]);
    }

    public function printBEO(Request $request, $id)
    {
        ini_set('max_execution_time', 100);
        $planner = Planner::find($id);
        $formattedDate = Carbon::now()->format('F d Y');
        $package_menus = PackageMenu::where('package_id', $planner->package_id)
            ->whereHas('planners', function ($query) use ($planner) {
                $query->where('planner_id', $planner->id);
            })
            ->get();

        $plannerStaffingsServer = PlannerStaffing::where('planner_id', $planner->id)
            ->whereHas('user', function ($query) {
                $query->where('job_type_id', 5);
            })->get();
        $plannerStaffingsBusboy = PlannerStaffing::where('planner_id', $planner->id)
            ->whereHas('user', function ($query) {
                $query->where('job_type_id', 3);
            })->get();
        $plannerStaffingsDishwasher = PlannerStaffing::where('planner_id', $planner->id)
            ->whereHas('user', function ($query) {
                $query->where('job_type_id', 4);
            })->get();

        return view("pdf.beo", [
            'planner' => $planner,
            'formattedDate' => $formattedDate,
            'package_menus' => $package_menus,
            'plannerStaffingsServer' => $plannerStaffingsServer,
            'plannerStaffingsBusboy' => $plannerStaffingsBusboy,
            'plannerStaffingsDishwasher' => $plannerStaffingsDishwasher,
        ]);
    }

    public function generateEmployeeActivity(Request $request)
    {
        ini_set('max_execution_time', 100);
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
        $formattedDate = Carbon::now()->format('F d Y');
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

        if ($startDate) {
            $attendance = $attendance->whereMonth('task_date', '>=', $startDate)->whereYear('task_date', '>=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date', '>=', $yearNow);
        }

        if ($endDate) {
            $attendance = $attendance->whereMonth('task_date', '<=', $endDate)->whereYear('task_date', '<=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date', '<=', $yearNow);
        }

        $attendance = $attendance->orderBy('present', 'ASC')->get();

        $first = $startDate == "" ? Carbon::now()->startOfMonth()->format('Y-m-d') : $yearNow . '-' . $startDate;
        $last = $endDate == "" ? Carbon::now()->endOfMonth()->format('Y-m-d') :  $yearNow . '-' . $endDate;

        view()->share('employee_activity', $attendance);

        $pdf = \PDF::loadView('pdf.employee_activities', [
            'attendance' => $attendance,
            'formattedDate' => $formattedDate,
            "startDate" => Carbon::parse($first ?? Carbon::now())->format('M d, Y'),
            "endDate" => Carbon::parse($last ?? Carbon::now())->endOfMonth()->modify('0 month')->format('M d, Y')
        ]);

        return $pdf->download("Employee-Monthly-Activities-" . Carbon::now()->format('m-d-Y') . ".pdf");
    }

    public function printEmployeeActivity(Request $request)
    {
        ini_set('max_execution_time', 100);
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
        $formattedDate = Carbon::now()->format('F d Y');
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



        if ($startDate) {
            $attendance = $attendance->whereMonth('task_date', '>=', $startDate)->whereYear('task_date', '>=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date', '>=', $yearNow);
        }

        if ($endDate) {
            $attendance = $attendance->whereMonth('task_date', '<=', $endDate)->whereYear('task_date', '<=', $yearNow);
        } else {
            $attendance = $attendance->whereYear('task_date', '<=', $yearNow);
        }

        $attendance = $attendance->orderBy('present', 'ASC')->get();

        $first = $startDate == "" ? Carbon::now()->startOfMonth()->format('Y-m-d') : $yearNow . '-' . $startDate;
        $last = $endDate == "" ? Carbon::now()->endOfMonth()->format('Y-m-d') :  $yearNow . '-' . $endDate;

        return view("pdf.employee_activities", [
            'attendance' => $attendance,
            'formattedDate' => $formattedDate,
            "startDate" => Carbon::parse($first ?? Carbon::now())->format('M d, Y'),
            "endDate" => Carbon::parse($last ?? Carbon::now())->endOfMonth()->modify('0 month')->format('M d, Y')
        ]);
    }
}
