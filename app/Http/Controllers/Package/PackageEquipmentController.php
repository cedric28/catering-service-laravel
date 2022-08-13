<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PackageEquipments;
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

            $user = \Auth::user()->id;
            if($request->equipment_id){
                $validator = Validator::make($request->all(), [
                    'quantity' => 'required|numeric',
                    
                ], $messages);
    
                if ($validator->fails()) {
                    return response()->json([
                        'data' => $validator->errors()
                    ], 422);
                }

                $equipmentPackage = PackageEquipments::find($request->equipment_id);
                $equipmentPackage->quantity =  $request->quantity;
                $equipmentPackage->package_id = $request->package_id;
                $equipmentPackage->updater_id = $user;
                $equipmentPackage->save();
            } else {
                $validator = Validator::make($request->all(), [
                    'inventory_id' => 'required|integer',
                    'package_id' => 'required|integer',
                    'quantity' => 'required|numeric|gt:0',
                    
                ], $messages);
    
                if ($validator->fails()) {
                    return response()->json([
                        'data' => $validator->errors()
                    ], 422);
                }
    
                $equipmentPackage = PackageEquipments::where([
                    'inventory_id' => $request->inventory_id,
                    'package_id' => $request->package_id
                ])->first();
     
                if ($equipmentPackage === null) {
                    $equipmentPackage = new PackageEquipments([
                        'inventory_id' => $request->inventory_id,
                        'package_id' => $request->package_id,
                        'quantity' =>  $request->quantity,
                        'creator_id' => $user,
                        'updater_id' => $user
                    ]);
                } else {
                    $equipmentPackage->quantity = ($equipmentPackage->quantity + $request->quantity);
                }
            
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
}
