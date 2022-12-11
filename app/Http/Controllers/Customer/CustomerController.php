<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Log;
use App\Customer;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("customer.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("customer.create");
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
                'customer_firstname' => 'required|string|max:50',
                'customer_lastname' => 'required|string|max:50',
                'contact_number' => 'required|digits:10'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            //save customer
            $customer = new Customer();
            $customer->customer_firstname = $request->customer_firstname;
            $customer->customer_lastname = $request->customer_lastname;
            $customer->contact_number = $request->contact_number;
            $customer->save();



            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " create customer " . $customer->customer_lastname . ", " . $customer->customer_firstname . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            /*
             | @End Transaction
             |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('customers.edit', $customer->id)
                ->with('successMsg', 'Customer Details Save Successful');
        } catch (\Exception $e) {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customer.edit', [
            'customer' => $customer
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
            $customer = Customer::findOrFail($id);

            //validate request value
            $validator = Validator::make($request->all(), [
                'customer_firstname' => 'required|string|max:50',
                'customer_lastname' => 'required|string|max:50',
                'contact_number' => 'required|digits:10'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            $customer->customer_firstname = $request->customer_firstname;
            $customer->customer_lastname = $request->customer_lastname;
            $customer->contact_number = $request->contact_number;
            $customer->save();


            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " update customer " . $customer->customer_firstname . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            /*
             | @End Transaction
             |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('customers.edit', $customer->id)
                ->with('successMsg', 'Customer Data Update Successful');
        } catch (\Exception $e) {
            //if error occurs rollback the data from it's previos state
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        ////prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $customer = Customer::findOrFail($id);
        $customer->delete();

        $log = new Log();
        $log->log = "User " . \Auth::user()->email . " delete customer " . $customer->customer_firstname . " at " . Carbon::now();
        $log->creator_id =  \Auth::user()->id;
        $log->updater_id =  \Auth::user()->id;
        $log->save();
    }

    public function restore($id)
    {
        \DB::beginTransaction();
        try {

            $customer = Customer::onlyTrashed()->findOrFail($id);

            /* Restore category */
            $customer->restore();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " restore customer " . $customer->customer_firstname . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
