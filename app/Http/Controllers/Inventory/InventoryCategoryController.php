<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InventoryCategory;
use Validator;

class InventoryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory_categories = InventoryCategory::all();

        return view('inventory.category.index', [
            'inventory_categories' => $inventory_categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        return view('inventory.category.create');
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

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:inventory_categories,name'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $inventory_category = new InventoryCategory();
            $inventory_category->name = $request->name;
            $inventory_category->creator_id = $user;
            $inventory_category->updater_id = $user;
            $inventory_category->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();


            return redirect()->route('inventory-category.create')
                ->with('successMsg', 'Inventory Category created successfully');
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
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory_category = InventoryCategory::findOrFail($id);

        return view('inventory.category.show')->with(['inventory_category' => $inventory_category]);
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

        $inventory_category = InventoryCategory::findOrFail($id);

        return view('inventory.category.edit')->with([
            'inventory_category' => $inventory_category
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

            $inventory_category = InventoryCategory::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:inventory_categories,name,' . $inventory_category->id,
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $inventory_category->name = $request->name;
            $inventory_category->updater_id = $user;
            $inventory_category->save();

            /*
        | @End Transaction
        |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('inventory-category.edit', $inventory_category->id)
                ->with('successMsg', 'Inventory Category updated successfully');
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
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $inventory_category = InventoryCategory::findOrFail($id);
        $inventory_category->delete();
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

            $inventory_category = InventoryCategory::onlyTrashed()->findOrFail($id);

            /* Restore inventory_category */
            $inventory_category->restore();


            \DB::commit();
            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
