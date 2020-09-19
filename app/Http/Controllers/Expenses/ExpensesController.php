<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expenses;
use App\Category;
use Validator;
use Carbon\Carbon, DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expenses::all();

        return view('expense.index', [
            'expenses' => $expenses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        
        return view("expense.create",[
            'categories' => $categories
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
         /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            //validate request value
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'amount' => 'required|numeric',
                'entry_date' => 'required'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            
            //check current user
            $user = \Auth::user()->id;
            
            $dates = explode(' - ', $request->entry_date);
            $entryDate = Carbon::parse($dates[0])->format('Y-m-d');
       
            $expense = new Expenses();
            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->entry_date = $entryDate;
            $expense->creator_id = $user;
            $expense->updater_id = $user;
            $expense->save();
          
            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('expense.create')
                        ->with('successMsg','Expense Data Save Successful');
         
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
     
        $expense = Expenses::withTrashed()->findOrFail($id);

        return view('expense.show', [
            'expense' => $expense
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
        
        $expense = Expenses::withTrashed()->findOrFail($id);
        
        $categories = Category::all();
        
        return view('expense.edit', [
            'expense' => $expense,
            'categories' => $categories
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
        \DB::beginTransaction();

        try {
            //check current User
            $user = \Auth::user();
          
            $expense = Expenses::withTrashed()->findOrFail($id);
           
            //validate request value
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|integer',
                'amount' => 'required|numeric',
                'entry_date' => 'required'
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
            
          
            $user = \Auth::user();
            $dates = explode(' - ', $request->entry_date);
            $entryDate = Carbon::parse($dates[0])->format('Y-m-d');

            $expense->category_id = $request->category_id;
            $expense->amount = $request->amount;
            $expense->entry_date = $entryDate;
            $expense->updater_id = $user->id;
            $expense->update();

            
            \DB::commit();

            return back()->with("successMsg","Expense Update Successfully");

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
        //delete expense
        $expense = Expenses::findOrFail($id);
        $expense->delete();
    }
}
