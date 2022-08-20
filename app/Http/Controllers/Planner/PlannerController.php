<?php

namespace App\Http\Controllers\Planner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use App\Planner;
use App\PaymentStatus;

class PlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
             //validate request value
             $validator = Validator::make($request->all(), [
                'event_name' => 'required|string|max:50|unique:planners,event_name',
                'event_venue' => 'required|string|max:200',
                'event_date' => 'required|string',
                'package_id' => 'required|integer',
                'no_of_guests' => 'required|numeric',
                'note' => 'max:200',
                'payment_status_id' => 'required|integer',
                'customer_fullname' => 'required|string|max:50',
                'contact_number' => 'required|digits:10'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

             
            //check current user
            $user = \Auth::user()->id;

            $package = Package::find($request->package_id);
           
            //save category
            $planner = new Planner();
            $planner->or_no = $this->generateUniqueCode();
            $planner->event_name = $request->event_name;
            $planner->event_venue = $request->event_venue;
            $planner->no_of_guests = $request->no_of_guests;
            $planner->event_date = $request->event_date;
            $planner->event_time = $request->event_time;
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

            return redirect()->route('category.create')
                        ->with('successMsg','Category Save Successful');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function generateUniqueCode()
    {
        do {
            $or_no = 'CM' . random_int(1000000000, 9999999999);
        } while (Planner::where("or_no", "=", $or_no)->first());

        return $or_no;
    }
}
