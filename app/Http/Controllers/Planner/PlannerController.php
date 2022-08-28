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
use App\PlannerEquipment;
use App\PlannerOther;
use App\PlannerTimeTable;
use App\PlannerStaffing;
use App\User;
use Validator;

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

        return view("planner.create",[
            'packages' => $packages,
            'paymentStatus' => $paymentStatus
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
                'payment_status_id.required' => 'Please select Payment Status'
            ];
             //validate request value
             $validator = Validator::make($request->all(), [
                'event_name' => 'required|string|max:50|unique:planners,event_name',
                'event_venue' => 'required|string|max:200',
                'event_date' => 'required|string|unique:planners,event_date',
                'package_id' => 'required|integer',
                'no_of_guests' => 'numeric|gt:0',
                'note' => 'max:200',
                'payment_status_id' => 'required|integer',
                'customer_fullname' => 'required|string|max:50',
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
            $planner->customer_fullname = $request->customer_fullname;
            $planner->contact_number = $request->contact_number;
            $planner->total_price = $package->package_price;
            $planner->creator_id = $user;
            $planner->updater_id = $user;
            $planner->save();

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
        //
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
        $this->authorize("isAdmin");

        $planner = Planner::findOrFail($id);
        $plannerDate = $planner->event_date;
        $package_tasks = PackageTask::where('package_id',$planner->package_id)->get();
        $package_equipments = PackageEquipments::where('package_id',$planner->package_id)->get();
        $package_others = PackageOther::where('package_id',$planner->package_id)->get();
        $package_menus = PackageMenu::where('package_id',$planner->package_id)->get();
        $usersHeadStaff = User::where('job_type_id',2)->get();
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
            'usersStaffJobTypes' => $usersStaffJobTypes
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
                'payment_status_id.required' => 'Please select Payment Status'
            ];
             //validate request value
             $validator = Validator::make($request->all(), [
                'event_name' => 'required|unique:planners,event_name,' . $planner->id,
                'event_venue' => 'required|string|max:200',
                'event_date' => 'required|string|unique:planners,event_date,' . $planner->id,
                'package_id' => 'required|integer',
                'no_of_guests' => 'numeric|gt:0',
                'note' => 'max:200',
                'payment_status_id' => 'required|integer',
                'customer_fullname' => 'required|string|max:50',
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
         
            $planner->or_no = $this->generateUniqueCode();
            $planner->event_name = $request->event_name;
            $planner->event_venue = $request->event_venue;
            $planner->no_of_guests = $package->package_pax;
            $planner->event_date = $eventDate;
            $planner->event_time = $eventTime;
            $planner->package_id = $package->id;
            $planner->note = $request->note;
            $planner->payment_status_id = $request->payment_status_id;
            $planner->customer_fullname = $request->customer_fullname;
            $planner->contact_number = $request->contact_number;
            $planner->total_price = $package->package_price;
            $planner->updater_id = $user;
            $planner->save();

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
            $messages = [
                'user_id.required' => 'Staff field is required',
                'task_type.required' => 'Task Type field is required',
                'package_task_id.unique' => 'The Task in Tasks Menu has already been taken',
                'task_date.unique' => 'The Task Date/Time in Tasks Menu has already been taken',
                'user_id.unique' => 'The User in Tasks Menu has already been taken in another Event',
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
            'task_date'=> 'required|string',
            'task_date' => [
                'required',
                Rule::unique('planner_tasks')->where(function ($query) use($request) {
                    $taskDateTime = explode(" | ", $request->task_date);
                    $taskDate = $taskDateTime[0];
                    $taskTime = $taskDateTime[1];
                    return $query->where('planner_id', $request->planner_id)
                    ->where('task_time', $taskTime)
                    ->where('task_date', $taskDate);
                }),
            ],
            'task_type'=> 'required|string',
            'user_id'=> [
                'required',
                'integer',
                Rule::unique('planner_tasks')->where(function ($query) use($request) {
                    $taskDateTime = explode(" | ", $request->task_date);
                    $taskDate = $taskDateTime[0];
                    $taskTime = $taskDateTime[1];
                    return $query->where('user_id', $request->user_id)
                    ->where('task_time', $taskTime)
                    ->where('task_date', $taskDate);
                })
            ],
            'planner_id'=> 'required|integer'
            ],$messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $taskDateTime = explode(" | ", $request->task_date);
            $taskDate = $taskDateTime[0];
            $taskTime = $taskDateTime[1];

            $planner_task = new PlannerTask();

            $planner_task->planner_id = $request->planner_id;
            $planner_task->package_task_id = $request->package_task_id;
            $planner_task->user_id = $request->user_id;
            $planner_task->task_date = $taskDate;
            $planner_task->task_time = $taskTime;
            $planner_task->task_type = $request->task_type;
            $planner_task->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Tasks in Tasks Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
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
                Rule::unique('planner_tasks')->where(function ($query) use($request) {
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

            \DB::commit();

            return back()->with("successMsg", "Successfully Add Staff in Employee Staffing Menu");

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
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

    public function printBEO(Request $request)
    {
        
    }
}
