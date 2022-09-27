<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Package;
use App\Planner;
use App\PaymentStatus;
use App\PackageTask;
use App\PackageEquipments;
use App\PackageOther;
use App\PackageMenu;
use App\PlannerTask;
use App\JobType;
use App\Inventory;
use App\PlannerEquipment;
use App\PlannerOther;
use App\PlannerTimeTable;
use App\PlannerStaffing;
use App\PlannerTaskStaff;
use App\Payment;
use App\PaymentType;
use App\User;
use App\TaskStaffNotification;
use App\TaskNotification;
use App\MainPackage;
use App\Category;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $planners = Planner::find(1);
        // dd($planners->package->main_package);
        return view("planner.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $paymentStatus = PaymentStatus::all();
        $package_categories = MainPackage::all();
        $food_categories = Category::all();
        $inventories = Inventory::all();
        return view("planner.create",[
            'packages' => $packages,
            'paymentStatus' => $paymentStatus,
            'package_categories' => $package_categories,
            'food_categories' => $food_categories,
            'inventories' => $inventories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            $messages = [
                'event_date.unique' => 'The Event Date has already been taken. Please choose another Date',
                'payment_status_id.required' => 'Please select Payment Status',
                'event_date.gte' => 'The :attribute event date must be greater than or equal to date today.',
            ];
             //validate request value
             $validator = Validator::make($request->all(), [
                'event_name' => 'required|string|max:50|unique:planners,event_name',
                'event_venue' => 'required|string|max:200',
                // 'event_date' => 'required|string|unique:planners,event_date',
                'event_date' => 'required|string',
                'package_id' => 'required|integer',
                'no_of_guests' => 'numeric|gt:0',
                'note' => 'max:200',
                'payment_status_id' => 'required|integer',
                'customer_firstname' => 'required|string|max:50',
                'customer_lastname' => 'required|string|max:50',
                'contact_number' => 'required|digits:10'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

             
            //check current user
            $user = \Auth::user()->id;

            $package = Package::find($request->package_id);
            $eventDateTime = explode(" | ", $request->event_date);
            $eventDate = $eventDateTime[0];
            $eventTime = $eventDateTime[1];
            // $eventTime = substr($eventDateTime[1],0,5);
            //save category
            $planner = new Planner();
            $planner->or_no = $this->generateUniqueCode();
            $planner->event_name = $request->event_name;
            $planner->event_venue = $request->event_venue;
            $planner->no_of_guests =  $package->package_pax;
            $planner->event_date = $eventDate;
            $planner->event_time = $eventTime;
            $planner->package_id = $package->id;
            $planner->note = $request->note;
            $planner->payment_status_id = $request->payment_status_id;
            $planner->customer_fullname = $request->customer_firstname . ' ' . $request->customer_lastname ;
            $planner->contact_number = $request->contact_number;
            $planner->total_price = $package->package_price;
            $planner->creator_id = $user;
            $planner->updater_id = $user;
            $planner->save();

            $plannerTime = [
                [
                    'task_name' => 'Truck Departure',
                    'task_time' => '12:01 AM'
                ],
                [
                    'task_name' => 'Truck Arrival',
                    'task_time' => '12:02 AM'
                ],
                [
                    'task_name' => 'Equipment Checklist',
                    'task_time' => '12:03 AM'
                ],
                [
                    'task_name' => 'Venue Ready Time',
                    'task_time' => '12:04 AM'
                ],
                [
                    'task_name' => 'Buffet Service',
                    'task_time' => '12:05 AM'
                ],
                [
                    'task_name' => 'Pack-up',
                    'task_time' => '12:06 AM'
                ],
                [
                    'task_name' => 'Equipment Checklist (Packup)',
                    'task_time' => '12:07 AM'
                ],
                [
                    'task_name' => 'End Time',
                    'task_time' => '12:08 AM'
                ],
                [
                    'task_name' => 'Staff Departure',
                    'task_time' => '12:09 AM'
                ],
            ];

            foreach ($plannerTime as $key => $time) {
    
                // Create Role
                $timeObj = PlannerTimeTable::create([
                    'planner_id' => $planner->id,
                    'task_name' => $time['task_name'],
                    'task_time' => $time['task_time'],
                ]);
            }

             /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('planners.edit', $planner->id)
            ->with('successMsg', 'Event Data Save Successful');

        } catch(\Exception $e) {
            //if error occurs rollback the data from it's previos state
           \DB::rollback();
           return back()->withErrors($e->getMessage());
       }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //prevent other user to access to this page
        $this->authorize("isHeadStaffOrAdmin");

        $planner = Planner::findOrFail($id);
        $plannerDate = $planner->event_date;
        $package_tasks = PackageTask::where('package_id',$planner->package_id)->get();
        $package_equipments = PackageEquipments::where('package_id',$planner->package_id)->get();
        $package_others = PackageOther::where('package_id',$planner->package_id)->get();
        $package_menus_beo = PackageMenu::where('package_id',$planner->package_id)
                                ->whereHas('planners', function($query) use ($planner){
                                        $query->where('planner_id',$planner->id);
                                })
                                ->get();

        $package_menus = PackageMenu::where('package_id',$planner->package_id)
                                ->get();
        $plannerStaffingsServer = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',5);
                            })->get();
        $plannerStaffingsBusboy = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',3);
                            })->get();
        $plannerStaffingsDishwasher = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',4);
                            })->get();

        return view('planner.show', [
            'planner' => $planner,
            'package_tasks' => $package_tasks,
            'package_equipments' =>  $package_equipments,
            'package_others' => $package_others,
            'package_menus' => $package_menus,
            'plannerStaffingsServer' => $plannerStaffingsServer,
            'plannerStaffingsBusboy' => $plannerStaffingsBusboy,
            'plannerStaffingsDishwasher' => $plannerStaffingsDishwasher,
            'package_menus_beo' => $package_menus_beo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //prevent other user to access to this page
        // $this->authorize("isAdmin");
        // dd(\Auth::user()->id);
        $planner = Planner::findOrFail($id);
        $plannerDate = $planner->event_date;
        $package_tasks = PackageTask::where('package_id',$planner->package_id)->get();
        $package_equipments = PackageEquipments::where('package_id',$planner->package_id)->get();
        $package_others = PackageOther::where('package_id',$planner->package_id)->get();
        $package_menus_beo = PackageMenu::where('package_id',$planner->package_id)
                            ->whereHas('planners', function($query) use ($planner){
                                    $query->where('planner_id',$planner->id);
                            })
                            ->get();

        $package_menus = PackageMenu::where('package_id',$planner->package_id)
                            ->get();

        // $planner_package_menu_planner = PackageMenuPlanner::where('planner_id', $planner->id)->get();

        // PackageMenu::where('package_id',$planner->package_id)
        //                     ->whereHas('planners', function($query) use ($planner){
        //                         $query->where('package_menu_id',$planner->package_id);
        //                     })->get();
        $plannerStaffingsServer = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',5);
                            })->get();
        $plannerStaffingsBusboy = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',3);
                            })->get();
        $plannerStaffingsDishwasher = PlannerStaffing::where('planner_id',$planner->id)
                            ->whereHas('user', function($query){
                                $query->where('job_type_id',4);
                            })->get();
        // $usersHeadStaff = User::whereDoesntHave('planner_task_staffs', function($query) use ($planner){
        //                         $query->whereHas('planner_task', function($query) use($planner) {
        //                             $query->where('planner_id', $planner->id);
        //                         })
        //                         ->where('task_date', $planner->event_date);
        //                 })
        //                 ->where('job_type_id',2)
        //                 ->get();
        // $usersHeadStaff = User::whereDoesntHave('planner_task_staffs')
        //                         ->where('job_type_id',2)
        //                         ->get();
        $usersHeadStaff = User::where('job_type_id',2)
                                ->get();
        $paymentTypes = PaymentType::all();
        $usersStaffJobTypes = User::whereIn('job_type_id',[3,4,5])->whereDoesntHave('planner_staffings',function (Builder $query) use ($plannerDate) {
            $query->where('task_date','=', $plannerDate);
        })->get();
    
        $packages = Package::all();
        $paymentStatus = PaymentStatus::all();
        $task_types = [
            ['type' => 'Pre-Event'],
            ['type' => 'Event'],
            ['type' => 'Post-Event']
        ];

        $time_tables_lists = [
            ['task_name' => 'Truck Departure'],
            ['task_name' => 'Truck Arrival'],
            ['task_name' => 'Equipment Checklist'],
            ['task_name' => 'Venue Ready Time'],
            ['task_name' => 'Buffet Service'],
            ['task_name' => 'Pack-up'],
            ['task_name' => 'Equipment Checklist (Packup)'],
            ['task_name' => 'End Time'],
            ['task_name' => 'Staff Departure'],
        ];

        $taskStatus = [
            ['status' => 'pending'],
            ['status' => 'finished']
        ];

        $plannerStatus = [
            ['status' => 'pending'],
            ['status' => 'on-going'],
            ['status' => 'completed']
        ];

        $equipmentStatus = [
            ['status' => 'idle'],
            ['status' => 'in-use'],
            ['status' => 'returned']
        ];

        $plannerOther = PlannerOther::where('planner_id',$planner->id)->get();
       
        $servicePriceTotal = 0;
        if(count($plannerOther) > 0 ){
            foreach($plannerOther as $other){
                $packageOtherServicePrice = PackageOther::select(\DB::raw("SUM(service_price) as price"))->where('id',$other->package_other_id)->get();
                $servicePriceTotal +=$packageOtherServicePrice[0]->price;
            }
        }

        $overallPayment  = 0;
        $payments = Payment::select(\DB::raw("SUM(payment_price) as price"))->where('planner_id',$planner->id)->get();
        if(count($payments) > 0){
            foreach($payments as $payment){
                $overallPayment += $payment->price;
            }
        }
     
        $totalBalance = $planner->total_price + $servicePriceTotal - $overallPayment;

        return view('planner.edit', [
            'planner' => $planner,
            'packages' => $packages,
            'paymentStatus' => $paymentStatus,
            'package_tasks' => $package_tasks,
            'usersHeadStaff' => $usersHeadStaff,
            'task_types' => $task_types,
            'package_equipments' =>  $package_equipments,
            'package_others' => $package_others,
            'package_menus' => $package_menus,
            'usersStaffJobTypes' => $usersStaffJobTypes,
            'paymentTypes' => $paymentTypes,
            'plannerStaffingsServer' => $plannerStaffingsServer,
            'plannerStaffingsBusboy' => $plannerStaffingsBusboy,
            'plannerStaffingsDishwasher' => $plannerStaffingsDishwasher,
            'taskStatus' => $taskStatus,
            'equipmentStatus' => $equipmentStatus,
            'plannerStatus' => $plannerStatus,
            'time_tables_lists' => $time_tables_lists,
            'totalBalance' => $totalBalance,
            'package_menus_beo' => $package_menus_beo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            $planner = Planner::findOrFail($id);

            $messages = [
                'event_date.unique' => 'The Event Date has already been taken. Please choose another Date',
                'payment_status_id.required' => 'Please select Payment Status',
                'event_date.after_or_equal' => 'The :attribute event date must be greater than or equal to date today.',
            ];
             //validate request value
             $validator = Validator::make($request->all(), [
                'event_name' => 'required|unique:planners,event_name,' . $planner->id,
                'event_venue' => 'required|string|max:200',
                'date_today' => '',
                // 'event_date' => 'string|unique:planners,event_date,' . $planner->id,
                'event_date' => 'required|string',
                'package_id' => 'required|integer',
                'no_of_guests' => 'numeric|gt:0',
                'note' => 'max:200',
                'payment_status_id' => 'required|integer',
                'customer_fullname' => 'required|string|max:50',
                'contact_number' => 'required|digits:10',
                'planner_status' => 'required|string'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

             
            //check current user
            $user = \Auth::user()->id;

            $package = Package::find($request->package_id);
            $eventDateTime = explode(" | ", $request->event_date);
            $eventDate = $eventDateTime[0];
            $eventTime = $eventDateTime[1];
            // $eventTime = substr($eventDateTime[1],0,5);
            //save category
            $plannerEventDate = "";
            $plannerEventTime = "";
            if($planner->event_date === $eventDate){
                $plannerEventDate =  $eventDate;
                $plannerEventTime =  $eventTime;
            } else {
                if($eventDate < date('Y-m-d')){
                    return back()->withErrors(['event_date' => 'The event date must be greater than or equal to date today.'])->withInput();
                } else {
                    $plannerEventDate = $eventDate;
                    $plannerEventTime = $eventTime;
                }
            }

            $planner->or_no = $this->generateUniqueCode();
            $planner->event_name = $request->event_name;
            $planner->event_venue = $request->event_venue;
            $planner->no_of_guests = $package->package_pax;
            $planner->event_date = $plannerEventDate;
            $planner->event_time = $eventTime;
            $planner->package_id = $package->id;
            $planner->note = $request->note;
            $planner->payment_status_id = $request->payment_status_id;
            $planner->customer_fullname = $request->customer_fullname;
            $planner->contact_number = $request->contact_number;
            $planner->total_price = $package->package_price;
            $planner->status = $request->planner_status;
            $planner->updater_id = $user;
            

            if($request->planner_status == 'completed'){
                $payments = Payment::where('planner_id',$planner->id)->get();
                if(count($payments) <= 0){
                    return back()->withErrors(['planner_status' => 'Please make a payment first and set other details before changing the status to completed'])->withInput();
                } else {
                    $planner->save();
                }
            } else {
                $planner->save();
            }

            $plannerStaffing = PlannerStaffing::where('planner_id', $planner->id)->update(['task_date' => $planner->event_date]);
             /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('planners.edit', $planner->id)
            ->with('successMsg', 'Event Data Update Successful');

        } catch(\Exception $e) {
            //if error occurs rollback the data from it's previos state
           \DB::rollback();
           return back()->withErrors($e->getMessage());
       }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $planner = Planner::findOrFail($id);
        $planner->delete();
    }

    public function restore($id)
    {
        \DB::beginTransaction();
        try {

            $planner = Planner::onlyTrashed()->findOrFail($id);

            /* Restore category */
            $planner->restore();

            // $log = new Log();
            // $log->log = "User " . \Auth::user()->email . " restore category " . $category->category_name . " at " . Carbon::now();
            // $log->creator_id =  \Auth::user()->id;
            // $log->updater_id =  \Auth::user()->id;
            // $log->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function showPlanner($id)
    {
        try {
        $planner = Planner::find($id);
        $formattedDate = Carbon::parse($planner->event_date)->format('F d Y');
        $packageName = $planner->package->name;
        $paymentStatus = $planner->payment_status->name;
        $payments = $planner->payments;

        return response()->json([
            'data' => $planner,
            'formattedDate' => $formattedDate,
            'package_name' => $packageName,
            'payment_status' => $paymentStatus,
            'payments' => $payments,
            'status' => 'success'
        ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }


    public function generateUniqueCode()
    {
        do {
            $or_no = 'CM' . random_int(1000000000, 9999999999);
        } while (Planner::where("or_no", "=", $or_no)->first());

        return $or_no;
    }

    public function storeTask(Request $request)
    {
        \DB::beginTransaction();
        try {

            $planner = Planner::find($request->planner_id);
            $messages = [
                'task_type.required' => 'Task Type field is required',
                'package_task_id.unique' => 'The Task Selected in Tasks Menu has already been taken',
                'task_date.unique' => 'The Task Date/Time Selected in Tasks Menu has already been taken',
                'task_date.after_or_equal' => 'The :attribute must be greater than or equal to date today.',
                // 'user_id.unique' => 'The User Selected in Tasks Menu has already been taken in another Event',
            ];
            //validate request value
            $validator = Validator::make($request->all(), [
            'package_task_id' => [
                'required',
                Rule::unique('planner_tasks')->where(function ($query) use($request) {
                    return $query->where('planner_id', $request->planner_id)
                    ->where('package_task_id', $request->package_task_id);
                }),
            ],
            // 'task_date' => [
            //     'required',
            //     'string',
            //     Rule::unique('planner_tasks')->where(function ($query) use($request) {
            //         $taskDateTime = explode(" | ", $request->task_date);
            //         $taskDate = $taskDateTime[0];
            //         $taskTime = $taskDateTime[1];
            //         return $query->where('planner_id', $request->planner_id)
            //         ->where('task_time', $taskTime)
            //         ->where('task_date', $taskDate);
            //     }),
            // ],
            'task_date' => 'required|string',
            'task_type'=> 'required|string',
            'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $taskDateTime = explode(" | ", $request->task_date);
            $taskDate = $taskDateTime[0];
            $taskTime = $taskDateTime[1];

            $plannerEventDate = "";
            $plannerEventTime = "";
            if($taskDate >= date('Y-m-d')){
                $plannerEventDate = $taskDate;
                $plannerEventTime = $taskTime;
            } else {
                return back()->withErrors([
                    'task_date' => 'The Task Date/Time must be greater than or equal to date today or less than or equal to actual event date.'])->withInput();
            }

            $planner_task = new PlannerTask();

            $planner_task->planner_id = $request->planner_id;
            $planner_task->package_task_id = $request->package_task_id;
            // $planner_task->user_id = $request->user_id;
            $planner_task->task_date = $plannerEventDate;
            $planner_task->task_time = $plannerEventTime;
            $planner_task->task_type = $request->task_type;
            $planner_task->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Tasks in Tasks Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function updateTask(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'task_type.required' => 'Task Type field is required',
                'package_task_id.unique' => 'The Task Selected in Tasks Menu has already been taken',
                'task_date.unique' => 'The Task Date/Time Selected in Tasks Menu has already been taken',
                'task_date.after_or_equal' => 'The :attribute must be greater than or equal to date today.',
                // 'user_id.unique' => 'The User Selected in Tasks Menu has already been taken in another Event',
            ];

            //validate request value
            $validator = Validator::make($request->all(), [
            'package_task_id' => [
                'required',
                Rule::unique('planner_tasks')->where(function ($query) use($request) {
                    return $query->where('planner_id', $request->planner_id)
                    ->where('package_task_id', $request->package_task_id);
                })->ignore($request->planner_task_ids),
            ],
            // 'task_date' => [
            //     'required',
            //     'string',
            //     Rule::unique('planner_tasks')->where(function ($query) use($request) {
            //         $taskDateTime = explode(" | ", $request->task_date);
            //         $taskDate = $taskDateTime[0];
            //         $taskTime = $taskDateTime[1];
            //         return $query->where('planner_id', $request->planner_id)
            //         ->where('task_time', $taskTime)
            //         ->where('task_date', $taskDate);
            //     })->ignore($request->planner_task_ids),
            // ],
            'task_date' => 'required|string',
            'task_type'=> 'required|string',
            'task_status'=> 'required|string',
            'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }
            $planner = Planner::find($request->planner_id);
            $planner_task = PlannerTask::find($request->planner_task_ids);
            
            $taskDateTime = explode(" | ", $request->task_date);
            $taskDate = $taskDateTime[0];
            $taskTime = $taskDateTime[1];

            $plannerEventDate = "";
            $plannerEventTime = "";
            if($planner_task->task_date === $taskDate){
                $plannerEventDate = $taskDate;
                $plannerEventTime = $taskTime;
            } else {
                if($taskDate < date('Y-m-d')){
                    return response()->json([
                        'data' => ['task_date' => 'The event date must be greater than or equal to date today or less than or equal to actual event date.']
                    ], 422);
                } else {
                    $plannerEventDate = $taskDate;
                    $plannerEventTime = $taskTime;
                }
            }

           
            $planner_task->package_task_id = $request->package_task_id;
            $planner_task->task_date = $plannerEventDate;
            $planner_task->task_time = $plannerEventTime;
            $planner_task->task_type = $request->task_type;
            $planner_task->status = $request->task_status;
            $planner_task->save();

            $planner_task_staff = PlannerTaskStaff::where('planner_task_id',$planner_task->id)->update(['task_date' => $planner_task->task_date]);
            \DB::commit();

            return response()->json([
                'data' => $planner_task,
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyTask(Request $request)
    {
        \DB::beginTransaction();
        try {
            ////prevent other user to access to this page
            $this->authorize("isAdmin");

            //delete category
            $plannerTask = PlannerTask::findOrFail($request->id);

            foreach ($plannerTask->planner_task_staffs as $key => $value) {
                TaskStaffNotification::where('planner_task_staff_id',$value['id'])->delete();
            }

            $plannerTask->planner_task_staffs()->delete();

            $plannerTask->delete();

            \DB::commit();
            
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
           
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function storeTaskStaff(Request $request)
    {
        \DB::beginTransaction();
        try {
            $messages = [
                'user_id.required' => 'Staff field is required',
                'user_id.unique' => 'The User Selected has already been taken in a task',
            ];

           
            //validate request value
            $validator = Validator::make($request->all(), [
            'user_id'=> [
                'required',
                'integer',
                Rule::unique('planner_task_staff')->where(function ($query) use($request) {
                    $plannerTask = PlannerTask::find($request->planner_task_id);
                    return $query->where('user_id', $request->user_id)
                            ->where('planner_task_id', $request->planner_task_id)
                            ->orWhere('task_date', $plannerTask->task_date);
                    // return $query->where('planner_task_id', $request->planner_task_id)
                    //             ->where('user_id', $request->user_id)
                    //             ->where('task_date', $plannerTask->task_date);
                }),
                // Rule::unique('planner_tasks')->where(function ($query) use($request) {
                //     $planner_task = PlannerTask::find($request->planner_task_id);
                //     return $query->where('task_date', $planner_task->task_date);
                // }),
            ],
            'planner_task_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }
           
            $plannerTask = PlannerTask::find($request->planner_task_id);
            $planner_task_staff = new PlannerTaskStaff();
            $planner_task_staff->planner_task_id = $request->planner_task_id;
            $planner_task_staff->user_id = $request->user_id;
            $planner_task_staff->task_date = $plannerTask->task_date;
            $planner_task_staff->save();

            $taskstaffNotification = new TaskStaffNotification();
            $taskstaffNotification->planner_task_staff_id = $planner_task_staff->id;
            $taskstaffNotification->user_id  = $planner_task_staff->user_id;
            $taskstaffNotification->save();

            \DB::commit();

            return response()->json([
                'data' => $planner_task_staff,
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyTaskStaff(Request $request)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $plannerTaskStaff = PlannerTaskStaff::findOrFail($request->id);

        $taskstaffNotification = TaskStaffNotification::where([
            ['planner_task_staff_id','=',$plannerTaskStaff->id ],
            ['user_id','=',$plannerTaskStaff->user_id ]
        ])->first();
        
        $taskstaffNotification->delete();

        if($plannerTaskStaff->delete()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function storeEquipment(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'package_equipment_id.required' => 'Equipment field is required',
                'package_equipment_id.unique' => 'The Equipment has already been taken',
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'package_equipment_id' => [
                    'required',
                    Rule::unique('planner_equipment')->where(function ($query) use($request) {
                        return $query->where('planner_id', $request->planner_id)
                        ->where('package_equipment_id', $request->package_equipment_id);
                    }),
                ],
                'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            
            $plannerEquipment = new PlannerEquipment();
            $plannerEquipment->planner_id = $request->planner_id;
            $plannerEquipment->package_equipment_id = $request->package_equipment_id;
            $plannerEquipment->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Equipment in Equipments Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function updateEquipment(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'status.required' => 'Status field is required',
                'return_qty.required' => 'Return Quantity field is required'
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'status' => 'required|string',
                'return_qty' => 'sometimes|required|integer',
                'planner_equipments_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }
            
            $plannerEquipment = PlannerEquipment::find($request->planner_equipments_id);
            $plannerEquipment->status = $request->status;
            // $plannerEquipment->return_qty =  $request->status == 'returned' ? $request->return_qty : 0;
            if($plannerEquipment->save()){
               $inventoryId = $plannerEquipment->package_equipment->inventory->id;
               $requiredQuantity = $plannerEquipment->package_equipment->quantity;
               $inventory = Inventory::find($inventoryId);
               if($plannerEquipment->status == 'returned'){
                    if($plannerEquipment->missing_qty == 0){
                        return response()->json([
                            'data' =>  ['status' => ['Set status to In-Use first before returning the item']]
                        ], 422);
                    }
                    $totalMissing = $plannerEquipment->missing_qty;
                    if($request->return_qty <= $totalMissing){
                        $inventory->quantity_available = $inventory->quantity_available + $request->return_qty;
                        $inventory->quantity_in_use =  $inventory->quantity_in_use - $request->return_qty;
                        $plannerEquipment->missing_qty = $plannerEquipment->missing_qty - $request->return_qty;
                        $plannerEquipment->return_qty =  $plannerEquipment->return_qty + $request->return_qty;
                        $plannerEquipment->save();
                    } else {
                        return response()->json([
                            'data' =>  ['return_qty' => ['Return Quantity must be less than or equal to Missing Quantity']]
                        ], 422);
                    }
               } else if($plannerEquipment->status == 'idle'){
                    if($plannerEquipment->missing_qty > 0){
                        $inventory->quantity_available = $inventory->quantity_available + $plannerEquipment->missing_qty;
                        $inventory->quantity_in_use =  $inventory->quantity_in_use - $plannerEquipment->missing_qty;
                        $plannerEquipment->return_qty = 0;
                        $plannerEquipment->missing_qty = 0;
                        $plannerEquipment->save();
                    }
               } else {
                if($plannerEquipment->missing_qty <= 0 && $plannerEquipment->return_qty <= 0){
                    $inventory->quantity_available = $inventory->quantity_available - $requiredQuantity;
                    $inventory->quantity_in_use =  $inventory->quantity_in_use + $requiredQuantity;
                    $plannerEquipment->missing_qty =  $requiredQuantity;
                    $plannerEquipment->save();
                } else {
                    return response()->json([
                        'data' =>  ['status' => ['The Item is currently in use']]
                    ], 422);
                }
               }
               $inventory->save();
            }

            \DB::commit();

            return response()->json([
                'data' => $inventory,
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyEquipment(Request $request)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $plannerEquipment = PlannerEquipment::findOrFail($request->id);

        if($plannerEquipment->delete()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function storeFood(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'foods.required' => 'Please Add atleast 2 foods',
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'foods' => 'required|array|min:2'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $planner = Planner::find($request->planner_id);

            $planner->package_menus()->sync($request->foods);

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Foods in Food Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function storeOther(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'package_other_id.required' => 'Other Service field is required',
                'package_other_id.unique' => 'The Service has already been taken',
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'package_other_id' => [
                    'required',
                    Rule::unique('planner_others')->where(function ($query) use($request) {
                        return $query->where('planner_id', $request->planner_id)
                        ->where('package_other_id', $request->package_other_id);
                    }),
                ],
                'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $plannerOther = new PlannerOther();
            $plannerOther->planner_id = $request->planner_id;
            $plannerOther->package_other_id = $request->package_other_id;
            $plannerOther->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Additional Service in Other Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroyOther(Request $request)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $plannerOther = PlannerOther::findOrFail($request->id);

        if($plannerOther->delete()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function storeStaffing(Request $request)
    {
        \DB::beginTransaction();
        try {
            $messages = [
                'user_id.required' => 'Staff field is required in Employee Staffing Menu',
                'user_id.unique' => 'The User in Employee Staffing Menu has already been taken in another Event',
            ];
          
            //validate request value
            $validator = Validator::make($request->all(), [
            'user_id'=> [
                'required',
                'integer',
                Rule::unique('planner_staffings')->where(function ($query) use($request) {
                    $planner = Planner::find($request->planner_id);
                    return $query->where('user_id', $request->user_id)
                    ->where('task_date', $planner->event_date);
                })
            ],
            'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $planner = Planner::find($request->planner_id);

            $planner_staffing = new PlannerStaffing();
            $planner_staffing->planner_id = $request->planner_id;
            $planner_staffing->user_id = $request->user_id;
            $planner_staffing->task_date = $planner->event_date;
            $planner_staffing->save();

            $taskNotification = new TaskNotification();
            $taskNotification->planner_staffing_id = $planner_staffing->id;
            $taskNotification->user_id = $planner_staffing->user_id;
            $taskNotification->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Staff in Employee Staffing Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroyStaffing(Request $request)
    {
        \DB::beginTransaction();
        try {
            ////prevent other user to access to this page
            $this->authorize("isAdmin");

            //delete category
            $plannerStaffing = PlannerStaffing::findOrFail($request->id);
            TaskNotification::where([
                ['user_id', $plannerStaffing->user_id],
                ['planner_staffing_id', $plannerStaffing->id],
            ])->delete();
        
            $plannerStaffing->delete();

            \DB::commit();

            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
            
        } catch (\Exception $e) {
            \DB::rollback();
             return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function changeAttendanaceStaffing(Request $request)
    {
        ////prevent other user to access to this page
        

        //delete category
        $plannerStaffing = PlannerStaffing::findOrFail($request->id);
        $plannerStaffing->attendance = $request->attendance;

        if($plannerStaffing->save()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function storeTimeTable(Request $request)
    {
        
        \DB::beginTransaction();
        try {

            $messages = [
                'package_other_id.required' => 'Other Service field is required',
                'task_name.unique' => 'The Task Name in Time Table has already been taken',
                'task_time.unique' => 'The Task Time in Time Table has already been taken',
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'task_name' => [
                    'required',
                    Rule::unique('planner_time_tables')->where(function ($query) use($request) {
                        return $query->where('planner_id', $request->planner_id)
                        ->where('task_name', $request->task_name);
                    }),
                ],
                'task_time' => [
                    'required',
                    Rule::unique('planner_time_tables')->where(function ($query) use($request) {
                        return $query->where('planner_id', $request->planner_id)
                        ->where('task_time', $request->task_time);
                    }),
                ],
                'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $plannerTimeTable = new PlannerTimeTable();
            $plannerTimeTable->planner_id = $request->planner_id;
            $plannerTimeTable->task_name = $request->task_name;
            $plannerTimeTable->task_time = $request->task_time;
            $plannerTimeTable->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Task Time Service in Time Table");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function updateTimeTable(Request $request)
    {
        \DB::beginTransaction();
        try {

            $messages = [
                'task_time.unique' => 'The Time in Time Table has already been taken',
            ];

             //validate request value
             $validator = Validator::make($request->all(), [
                'task_time' => [
                    'required',
                    Rule::unique('planner_time_tables')->where(function ($query) use($request) {
                        return $query->where('planner_id', $request->planner_id)
                        ->where('task_time', $request->task_time);
                    })->ignore($request->time_table_id),
                ],
                'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }

            $plannerTimeTable = PlannerTimeTable::find($request->time_table_id);
            $plannerTimeTable->task_time = $request->task_time;
            $plannerTimeTable->save();

            \DB::commit();

            return response()->json([
                'data' => $plannerTimeTable,
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyTimeTable(Request $request)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $plannerTimeTable = PlannerTimeTable::findOrFail($request->id);

        if($plannerTimeTable->delete()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function storePayment(Request $request)
    {
        \DB::beginTransaction();
        try {

             //validate request value
             $validator = Validator::make($request->all(), [
                'payment_price' => 'required|numeric',
                'payment_type' => 'required|string',
                'planner_id'=> 'required|integer'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $planner = Planner::find($request->planner_id);
            $plannerOther = PlannerOther::where('planner_id',$planner->id)->get();
           
            $servicePriceTotal = 0;
            if(count($plannerOther) > 0 ){
                foreach($plannerOther as $other){
                    $packageOtherServicePrice = PackageOther::select(\DB::raw("SUM(service_price) as price"))->where('id',$other->package_other_id)->get();
                    $servicePriceTotal +=$packageOtherServicePrice[0]->price;
                }
            }
         
            $totalBalance = $planner->total_price + $servicePriceTotal;
           
            $overallPayment  = 0;
            $payments = Payment::select(\DB::raw("SUM(payment_price) as price"))->where('planner_id',$planner->id)->get();
            if(count($payments) > 0){
                foreach($payments as $payment){
                    $overallPayment += $payment->price;
                }
            }

           
            $totalPayment = $overallPayment + $request->payment_price;
           
            if($totalPayment > $totalBalance){
                return back()->withErrors(['payment_price' => 'Payment Price must be less than or equal to Total Balance: ' .Str::currency($totalBalance)])->withInput();
            }

            $plannerPayment = new Payment();
            $plannerPayment->planner_id = $request->planner_id;
            $plannerPayment->payment_price = $request->payment_price;
            $plannerPayment->payment_type = $request->payment_type;
            $plannerPayment->creator_id = $user;
            $plannerPayment->updater_id = $user;
            $plannerPayment->save();

            if($totalPayment == $totalBalance){
                $planner->payment_status_id = 2;
                $planner->save();
            }

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Payment in Payment Section");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroyPayment(Request $request)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $plannerPayment = Payment::findOrFail($request->id);

        if($plannerPayment->delete()){
            return response()->json([
                'data' => 'success',
                'status' => 'success'
            ], 200);
        }
    }

    public function printBEO(Request $request)
    {
        
    }
}
