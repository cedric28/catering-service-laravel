<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\InventoryCategory;
use Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventories = Inventory::all();

        return view('inventory.index', [
            'inventories' => $inventories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");
        $inventory_categories = InventoryCategory::all();

        return view('inventory.create', [
            'inventory_categories' => $inventory_categories
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
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:inventories,name',
                'description' => 'required|string|max:255',
                'quantity' => 'required|numeric|gt:0',
                'inventory_category_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $inventory = new Inventory();
            $inventory->name = $request->name;
            $inventory->description = $request->description;
            $inventory->quantity = $request->quantity;
            $inventory->quantity_available = $request->quantity;
            $inventory->inventory_category_id = $request->inventory_category_id;
            $inventory->creator_id = $user;
            $inventory->updater_id = $user;
            $inventory->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();


            return redirect()->route('inventories.create')
                ->with('successMsg', 'Inventory created successfully');
        } catch (\Exception $e) {
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
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory = Inventory::findOrFail($id);

        return view('inventory.show')->with(['inventory' => $inventory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory = Inventory::findOrFail($id);
        $inventory_categories = InventoryCategory::all();

        return view('inventory.edit')->with([
            'inventory' => $inventory,
            'inventory_categories' => $inventory_categories
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
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $inventory = Inventory::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:inventories,name,' . $inventory->id,
                'description' => 'required|string|max:255',
                'quantity' => 'required|numeric|gt:0',
                'inventory_category_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $inventory->name = $request->name;
            $inventory->description = $request->description;
            $inventory->quantity = $request->quantity;
            $inventory->quantity_available = $request->quantity;
            $inventory->inventory_category_id = $request->inventory_category_id;
            $inventory->updater_id = $user;
            $inventory->save();

            /*
        | @End Transaction
        |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('inventories.edit', $inventory->id)
                ->with('successMsg', 'Inventory updated successfully');
        } catch (\Exception $e) {
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
        ini_set('max_execution_time', 100);
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        \DB::beginTransaction();
        try {

            $inventory = Inventory::onlyTrashed()->findOrFail($id);

            /* Restore inventory */
            $inventory->restore();


            \DB::commit();
            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
