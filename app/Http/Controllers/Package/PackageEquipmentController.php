<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\PackageEquipments;
use App\Package;
use Validator;

class PackageEquipmentController extends Controller
{
    public function addEquipment(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $messages = [
                'inventory_id.required' => 'The Equipment field is required.',
                'inventory_id.unique' => 'The Equipment has already been taken',
                'package_id.required' => 'The Package ID is required.',
            ];

            $uniqueRule = Rule::unique('package_equipments')->where(function ($query) use($request) {
                return $query->where('inventory_id', $request->inventory_id)
                ->where('package_id', $request->package_id);
            });

            if($request->equipment_id != 0){
                $uniqueRule = Rule::unique('package_equipments')->where(function ($query) use($request) {
                    return $query->where('inventory_id', $request->inventory_id)
                    ->where('package_id', $request->package_id);
                })->ignore($request->equipment_id);
            } 
            $user = \Auth::user()->id;
            // if($request->equipment_id){
                $validator = Validator::make($request->all(), [
                    // 'inventory_id' => 'required|integer|unique:package_equipments,inventory_id,' . $request->inventory_id . 'package_id,' . $request->package_id,
                    'package_id' => 'required|integer',
                    'inventory_id' => [
                        'required',
                        $uniqueRule
                       ,
                    ],
                    'quantity' => 'required|numeric|gt:1',
        
                    
                ], $messages);
    
                if ($validator->fails()) {
                    return response()->json([
                        'data' => $validator->errors()
                    ], 422);
                }

                if($request->equipment_id == 0){
                    $package = Package::find($request->package_id);
                    $equipmentPackage = new PackageEquipments();
                    $equipmentPackage->inventory_id = $request->inventory_id;
                    $equipmentPackage->quantity =  $request->quantity;
                    $equipmentPackage->package_id = $request->package_id;
                    $equipmentPackage->creator_id = $user;
                    $equipmentPackage->updater_id = $user;
                    $equipmentPackage->save();
                } else {
                    $equipmentPackage = PackageEquipments::find($request->equipment_id);
                    $equipmentPackage->inventory_id = $request->inventory_id;
                    $equipmentPackage->quantity =  $request->quantity;
                    $equipmentPackage->updater_id = $user;
                    $equipmentPackage->save();
                }

             /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return response()->json([
                'data' => $equipmentPackage,
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            //if error occurs rollback the data from it's previos state
            \DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 500);
        }
       
    }

    public function destroy($id)
    {
         //prevent other user to access to this page
         $this->authorize("isAdmin");

         $package = PackageEquipments::findOrFail($id);
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

            $package = PackageEquipments::onlyTrashed()->findOrFail($id);

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
