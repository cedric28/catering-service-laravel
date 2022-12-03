<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PlannerTask;
use App\PlannerTaskStaff;
use App\PlannerEquipment;
use App\PlannerOther;
use App\PlannerStaffing;
use App\PlannerTimeTable;
use App\Payment;
use Illuminate\Support\Facades\DB;

class PlannerDetailsFetchController extends Controller
{
    public function fetchPlannerTask(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'task_date',
            1 => 'task_type',
            2 => 'status',
            3 => 'created_at',
            4 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerTask::where('planner_id', $request->planner_id)->count();
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
            if (\Auth::user()->job_type_id != 1) {
                //if not admin
                $search = \Auth::user()->id;
                $posts = PlannerTask::where('planner_id', $request->planner_id)
                    ->where(function ($query) use ($search) {
                        $query->orWhereHas('planner_task_staffs', function ($query) use ($search) {
                            $query->where('user_id', '=', "{$search}");
                        });
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                //total number of filtered data
                $totalFiltered = PlannerTask::where('planner_id', $request->planner_id)->count();
            } else {
                //if admin
                $posts = PlannerTask::where('planner_id', $request->planner_id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                //total number of filtered data
                $totalFiltered = PlannerTask::where('planner_id', $request->planner_id)->count();
            }
        } else {
            $search = $request->input('search.value');

            if (\Auth::user()->job_type_id != 1) {
                //if not admin
                $user_id = \Auth::user()->id;
                $posts = PlannerTask::where('planner_id', $request->planner_id)
                    ->where(function ($query) use ($search) {
                        $query->orWhereHas('package_task', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('planner_task_staffs', function ($query) use ($user_id) {
                                $query->where('user_id', '=', "{$user_id}");
                            })
                            ->orWhere('task_date', 'like', "%{$search}%")
                            ->orWhere('task_time', 'like', "%{$search}%")
                            ->orWhere('task_type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                //total number of filtered data matching the search value request in the Category table	
                $totalFiltered = PlannerTask::where('planner_id', $request->planner_id)
                    ->where(function ($query) use ($search) {
                        $query->orWhereHas('package_task', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                            ->orWhereHas('planner_task_staffs', function ($query) use ($user_id) {
                                $query->where('user_id', '=', "{$user_id}");
                            })
                            ->orWhere('task_date', 'like', "%{$search}%")
                            ->orWhere('task_time', 'like', "%{$search}%")
                            ->orWhere('task_type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                    })->count();
            } else {

                //if admin
                $posts = PlannerTask::where('planner_id', $request->planner_id)
                    ->where(function ($query) use ($search) {
                        $query->orWhereHas('package_task', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                            ->orWhere('task_date', 'like', "%{$search}%")
                            ->orWhere('task_time', 'like', "%{$search}%")
                            ->orWhere('task_type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                //total number of filtered data matching the search value request in the Category table	
                $totalFiltered = PlannerTask::where('planner_id', $request->planner_id)
                    ->where(function ($query) use ($search) {
                        $query->orWhereHas('package_task', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                            ->orWhere('task_date', 'like', "%{$search}%")
                            ->orWhere('task_time', 'like', "%{$search}%")
                            ->orWhere('task_type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                    })->count();
            }
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $status = '';
                if ($r->status == 'pending') {
                    $status = '<span title="Danger" class="badge bg-info">PENDING</span>';
                } else {
                    $status = '<span title="Danger" class="badge bg-success">FINISHED</span>';
                }
                $nestedData['task_name'] = $r->package_task->name;
                $nestedData['task_date_and_time'] = $r->task_date . ' ' . $r->task_time;
                $nestedData['task_type'] = $r->task_type;
                $nestedData['task_status'] = $status;
                if ($request->planner_show == 0 && \Auth::user()->job_type_id == 1) {
                    $nestedData['action'] = '
                        <button name="settings" id="setting-planner-task-staff" data-id="' . $r->id . '" class="btn btn-success btn-xs">Staff Settings</button>
                        <button name="edit" id="edit-planner-task" data-my-planner-id="' . $r->planner_id . '"  data-id="' . $r->id . '" data-package-task-id="' . $r->package_task_id . '" data-event-date="' . $r->task_date . '" data-event-time="' . $r->task_time . '" data-task-type="' . $r->task_type . '" data-status="' . $r->status . '" class="btn btn-warning btn-xs">Edit</button>
                        <button name="delete" id="delete-planner-task" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                    ';
                } else {
                    $nestedData['action'] = '
                        <button name="edit" id="edit-planner-task" data-my-planner-id="' . $r->planner_id . '"  data-id="' . $r->id . '" data-package-task-id="' . $r->package_task_id . '" data-event-date="' . $r->task_date . '" data-event-time="' . $r->task_time . '" data-task-type="' . $r->task_type . '" data-status="' . $r->status . '" class="btn btn-warning btn-xs">Edit</button>
                    ';
                }
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

    public function fetchPlannerTaskStaff(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'task_date',
            1 => 'created_at',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerTaskStaff::where('planner_task_id', $request->planner_task_id)->count();
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
            $posts = PlannerTaskStaff::where('planner_task_id', $request->planner_task_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PlannerTaskStaff::where('planner_task_id', $request->planner_task_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PlannerTaskStaff::where('planner_task_id', $request->planner_task_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PlannerTaskStaff::where('planner_task_id', $request->planner_task_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
                })->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->user->name;
                $nestedData['action'] = '
                    <button name="delete" id="delete-planner-task-staff" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
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

    public function fetchPlannerEquipment(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'return_qty',
            1 => 'status',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerEquipment::where('planner_id', $request->planner_id)->count();
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
            $posts =  DB::table('planner_equipment')
                ->leftJoin('package_equipments', 'planner_equipment.package_equipment_id', '=', 'package_equipments.id')
                ->leftJoin('inventories', 'package_equipments.inventory_id', '=', 'inventories.id')
                ->select('planner_equipment.*', 'inventories.name as equipment_name', 'inventories.quantity_available as current_quantity', 'package_equipments.quantity as required_quantity')
                ->where([
                    ['planner_equipment.planner_id', $request->planner_id]
                ])->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = DB::table('planner_equipment')
                ->leftJoin('package_equipments', 'planner_equipment.package_equipment_id', '=', 'package_equipments.id')
                ->leftJoin('inventories', 'package_equipments.inventory_id', '=', 'inventories.id')
                ->select('planner_equipment.*', 'inventories.name as equipment_name', 'inventories.quantity_available as current_quantity', 'package_equipments.quantity as required_quantity')
                ->where([
                    ['planner_equipment.planner_id', $request->planner_id]
                ])->count();
        } else {
            $search = $request->input('search.value');

            $posts = DB::table('planner_equipment')
                ->leftJoin('package_equipments', 'planner_equipment.package_equipment_id', '=', 'package_equipments.id')
                ->leftJoin('inventories', 'package_equipments.inventory_id', '=', 'inventories.id')
                ->select('planner_equipment.*', 'inventories.name as equipment_name', 'inventories.quantity_available as current_quantity', 'package_equipments.quantity as required_quantity')
                ->where(function ($query) use ($search) {
                    $query->where('inventories.name', 'like', '%' . $search . '%')
                        ->orWhere('package_equipments.quantity', 'like', "%{$search}%")
                        ->orWhere('inventories.quantity_available', 'like', "%{$search}%")
                        ->orWhere('planner_equipment.return_qty', 'like', "%{$search}%")
                        ->orWhere('planner_equipment.status', 'like', "%{$search}%");
                })
                ->where([
                    ['planner_equipment.planner_id', $request->planner_id]
                ])->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered =  DB::table('planner_equipment')
                ->leftJoin('package_equipments', 'planner_equipment.package_equipment_id', '=', 'package_equipments.id')
                ->leftJoin('inventories', 'package_equipments.inventory_id', '=', 'inventories.id')
                ->select('planner_equipment.*', 'inventories.name as equipment_name', 'inventories.quantity_available as current_quantity', 'package_equipments.quantity as required_quantity')
                ->where(function ($query) use ($search) {
                    $query->where('inventories.name', 'like', '%' . $search . '%')
                        ->orWhere('package_equipments.quantity', 'like', "%{$search}%")
                        ->orWhere('inventories.quantity_available', 'like', "%{$search}%")
                        ->orWhere('planner_equipment.return_qty', 'like', "%{$search}%")
                        ->orWhere('planner_equipment.status', 'like', "%{$search}%");
                })
                ->where([
                    ['planner_equipment.planner_id', $request->planner_id]
                ])->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $remarks = '';
                $status = '';
                if ($r->status == 'idle' || $r->status == 'in-use') {
                    $totalNeed = $r->current_quantity - $r->required_quantity;
                    $remarks = $totalNeed < 0 ? '<span title="Danger" class="badge bg-danger">INSUFFICIENT (Need ' . abs($totalNeed) . ' quantity)</span>' : '<span title="Danger" class="badge bg-success">SUFFICIENT</span>';
                    $status = $r->status == 'idle' ? '<span title="Danger" class="badge bg-info">IDLE</span>' : '<span title="Danger" class="badge bg-success">IN-USE</span>';
                } else {
                    $totalReturned = $r->required_quantity - $r->return_qty;
                    $remarks = $totalReturned > 0 ? '<span title="Danger" class="badge bg-danger">INSUFFICIENT (Missing ' . abs($totalReturned) . ' quantity)</span>' : '<span title="Danger" class="badge bg-success">SUFFICIENT</span>';
                    $status = '<span title="Danger" class="badge bg-success">RETURNED</span>';
                }

                $nestedData['equipment_name'] = $r->equipment_name;
                $nestedData['required_quantity'] = $r->required_quantity;
                $nestedData['current_quantity'] = $r->current_quantity;
                $nestedData['returned_quantity'] = $r->return_qty;
                $nestedData['remarks'] = $remarks;
                $nestedData['status'] = $status;
                if ($r->status == 'idle') {
                    if ($request->planner_show == 0) {
                        $nestedData['action'] = '
                        <button name="edit" id="edit-planner-equipment" data-id="' . $r->id . '" data-planner-equipment-status="' . $r->status . '" data-return-qty="' . $r->return_qty . '" class="btn btn-warning btn-xs">Edit</button>
                        <button name="delete" id="delete-planner-equipment" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                    ';
                    }
                } else {
                    if ($request->planner_show == 0) {
                        $nestedData['action'] = '
                            <button name="edit" id="edit-planner-equipment" data-id="' . $r->id . '" data-planner-equipment-status="' . $r->status . '" data-return-qty="' . $r->return_qty . '" class="btn btn-warning btn-xs">Edit</button>
                        ';
                    }
                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"                => $data,
            'sdad' => $request->planner_task_id
        );

        //return the data in json response
        return response()->json($json_data);
    }

    public function fetchPlannerOther(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'planner_id',
            1 => 'package_other_id',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerOther::where('planner_id', $request->planner_id)->count();
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
            $posts = PlannerOther::where('planner_id', $request->planner_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PlannerOther::where('planner_id', $request->planner_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PlannerOther::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_other', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('service_price', 'like', "%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered =  PlannerOther::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('package_other', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('service_price', 'like', "%{$search}%");
                    });
                })->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['name'] = $r->package_other->name;
                $nestedData['service_price'] = \Str::currency($r->package_other->service_price);
                if ($request->planner_show == 0) {
                    $nestedData['action'] = '
                    <button name="delete" id="delete-planner-other" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                ';
                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"                => $data,
            'haah'             => $posts
        );

        //return the data in json response
        return response()->json($json_data);
    }

    public function fetchPlannerStaffing(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'attendance',
            1 => 'task_date',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerStaffing::where('planner_id', $request->planner_id)->count();
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
            $staffName = $request->input('columns.0.search.value');
            $staffAttendance = $request->input('columns.2.search.value');
            $staffDuty = $request->input('columns.1.search.value');
            $posts = PlannerStaffing::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($staffName, $staffDuty) {
                    $query->whereHas('user', function ($query) use ($staffName, $staffDuty) {
                        $query->where('name', 'like', "%{$staffName}%")
                            ->whereHas('job_type', function ($query) use ($staffDuty) {
                                $query->where('name', 'like', "%{$staffDuty}%");
                            });
                    });
                })->where('attendance', 'like', "%{$staffAttendance}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PlannerStaffing::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($staffName, $staffDuty) {
                    $query->whereHas('user', function ($query) use ($staffName, $staffDuty) {
                        $query->where('name', 'like', "%{$staffName}%")
                            ->whereHas('job_type', function ($query) use ($staffDuty) {
                                $query->where('name', 'like', "%{$staffDuty}%");
                            });
                    });
                })->where('attendance', 'like', "%{$staffAttendance}%")->count();
        } else {
            $search = $request->input('search.value');

            $posts =  PlannerStaffing::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhereHas('job_type', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    });
                })->orWhere('attendance', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered =  PlannerStaffing::where('planner_id', $request->planner_id)
                ->where(function ($query) use ($search) {
                    $query->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhereHas('job_type', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    });
                })->orWhere('attendance', 'like', "%{$search}%")->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $attendance = '';
                if ($r->attendance == 'inactive') {
                    $attendance = '<span title="Danger" class="badge bg-warning">' . strtoupper($r->attendance) . '</span>';
                } else {
                    $attendance = '<span title="Danger" class="badge bg-success">' . strtoupper($r->attendance) . '</span>';
                }

                $nestedData['fullname'] = $r->user->name;
                $nestedData['job_type'] = $r->user->job_type->name;
                $nestedData['attendance'] = $attendance;
                if ($r->attendance == 'inactive') {
                    if ($request->planner_show == 0) {
                        if (\Auth::user()->job_type_id != 1) {
                            $nestedData['action'] = '
                            <button name="edit" id="edit-planner-staffing" data-id="' . $r->id . '" data-attendance="active" class="btn btn-success btn-xs">ACTIVE</button>
                            ';
                        } else {
                            $nestedData['action'] = '
                            <button name="edit" id="edit-planner-staffing" data-id="' . $r->id . '" data-attendance="active" class="btn btn-success btn-xs">ACTIVE</button>
                            <button name="delete" id="delete-planner-staffing" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                            ';
                        }
                    }
                } else {
                    if ($request->planner_show == 0) {
                        $nestedData['action'] = '
                            <button name="edit" id="edit-planner-staffing" data-id="' . $r->id . '" data-attendance="inactive" class="btn btn-warning btn-xs">INACTIVE</button>
                        ';
                    }
                }

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"                => intval($request->input('draw')),
            "recordsTotal"        => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"                => $data,
            'sdad' => $request->planner_task_id
        );

        //return the data in json response
        return response()->json($json_data);
    }

    public function fetchPlannerTimeTable(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'task_time',
            1 => 'task_name',
            2 => 'action'
        );

        //get the total number of data in Category table
        $totalData = PlannerTimeTable::where('planner_id', $request->planner_id)->count();
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
            $posts = PlannerTimeTable::where('planner_id', $request->planner_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = PlannerTimeTable::where('planner_id', $request->planner_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = PlannerTimeTable::where('planner_id', $request->planner_id)
                ->orWhere('task_name', 'like', "%{$search}%")
                ->orWhere('task_time', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = PlannerTimeTable::where('planner_id', $request->planner_id)
                ->orWhere('task_name', 'like', "%{$search}%")
                ->orWhere('task_time', 'like', "%{$search}%")
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['task_time'] = $r->task_time;
                $nestedData['task_name'] = ucwords($r->task_name);
                if ($request->planner_show == 0) {
                    $nestedData['action'] = '
                        <button name="edit" id="edit-planner-time-table" data-time="' . $r->task_time . '" data-id="' . $r->id . '" class="btn btn-warning btn-xs">Edit</button>
                        <button name="delete" id="delete-planner-time-table" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                    ';
                }
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

    public function fetchPlannerPayments(Request $request)
    {
        //column list in the table Prpducts
        $columns = array(
            0 => 'created_at',
            1 => 'payment_price',
            2 => 'payment_type',
            3 => 'action'
        );

        //get the total number of data in Category table
        $totalData = Payment::where('planner_id', $request->planner_id)->count();
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
            $posts = Payment::where('planner_id', $request->planner_id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data
            $totalFiltered = Payment::where('planner_id', $request->planner_id)->count();
        } else {
            $search = $request->input('search.value');

            $posts = Payment::where('planner_id', $request->planner_id)
                ->orWhere('payment_price', 'like', "%{$search}%")
                ->orWhere('payment_type', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            //total number of filtered data matching the search value request in the Category table	
            $totalFiltered = Payment::where('planner_id', $request->planner_id)
                ->orWhere('payment_price', 'like', "%{$search}%")
                ->orWhere('payment_type', 'like', "%{$search}%")
                ->count();
        }


        $data = array();

        if ($posts) {
            //loop posts collection to transfer in another array $nestedData
            foreach ($posts as $r) {
                $nestedData['payment_type'] = ucwords($r->payment_type);
                $nestedData['payment_price'] =  \Str::currency($r->payment_price);
                $nestedData['created_at'] = date('m-d-Y', strtotime($r->created_at));
                if ($request->planner_show == 0) {
                    $nestedData['action'] = '
                        <button name="delete" id="delete-planner-time-table" data-id="' . $r->id . '" class="btn btn-danger btn-xs">Remove</button>
                    ';
                }
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
