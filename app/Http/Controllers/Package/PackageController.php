<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use App\MainPackage;
use App\Category;
use App\Inventory;
use Validator;

class PackageController extends Controller
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

        return view('package.index');
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
        $package_categories = MainPackage::all();

        return view('package.create', [
            'package_categories' => $package_categories
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

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:packages,name',
                'package_pax' => 'required|numeric|gt:0',
                'main_package_id' => 'required|integer',
                'package_price' => 'required|numeric|gt:0',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $package = new Package();
            $package->name = $request->name;
            $package->package_pax = $request->package_pax;
            $package->package_price = $request->package_price;
            $package->main_package_id = $request->main_package_id;
            $package->creator_id = $user;
            $package->updater_id = $user;
            $package->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('packages.edit', $package->id)
            ->with('successMsg', 'Package created successfully');
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
        $this->authorize("isAdmin");
        $package = Package::findOrFail($id);
        $package_categories = MainPackage::all();
        $food_categories = Category::all();
        $inventories = Inventory::all();

        return view('package.show', [
            'package' => $package,
            'package_categories' => $package_categories,
            'food_categories' => $food_categories,
            'inventories' => $inventories,
            'isShow' => 1
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
        $this->authorize("isAdmin");
        $package = Package::findOrFail($id);
        $package_categories = MainPackage::all();
        $food_categories = Category::all();
        $inventories = Inventory::all();

        return view('package.edit', [
            'package' => $package,
            'package_categories' => $package_categories,
            'food_categories' => $food_categories,
            'inventories' => $inventories,
            'isShow' => 0
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

            $package = Package::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:packages,name,' . $package->id,
                'package_pax' => 'required|numeric|gt:0',
                'main_package_id' => 'required|integer',
                'package_price' => 'required|numeric|gt:0',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $package->name = $request->name;
            $package->package_pax = $request->package_pax;
            $package->package_price = $request->package_price;
            $package->main_package_id = $request->main_package_id;
            $package->updater_id = $user;
            $package->save();

            /*
        | @End Transaction
        |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('packages.edit', $package->id)
                ->with('successMsg', 'Package updated successfully');
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

         $package = Package::findOrFail($id);
         $package->delete();
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

            $package = Package::onlyTrashed()->findOrFail($id);

            /* Restore package */
            $package->restore();


            \DB::commit();
            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

}
