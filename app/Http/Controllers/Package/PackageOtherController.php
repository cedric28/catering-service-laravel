<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PackageOther;
use Validator;


class PackageOtherController extends Controller
{
    public function addOther(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $messages = [
                'name.required' => 'The Name field is required.',
                'name.unique' => 'The name has already been taken',
                'package_id.required' => 'The Package ID is required.',
            ];

            $validator = Validator::make($request->all(), [
                // 'category_id' => 'required|integer',
                'name' => 'required|string|max:50|unique:package_others,name,' . $request->name . ',id,package_id,' . $request->package_id,
                'package_id' => 'required|integer',
                'service_price' => 'required|numeric|gt:0',
                
            ], $messages);
           
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }

            $user = \Auth::user()->id;

            if($request->other_id){

                $otherPackage = PackageOther::find($request->other_id);
                $otherPackage->name = $request->name;
                $otherPackage->service_price = $request->service_price;
                $otherPackage->updater_id = $user;
                $otherPackage->save();
            } else {
                $otherPackage = new PackageOther();
                $otherPackage->package_id = $request->package_id;
                $otherPackage->name = $request->name;
                $otherPackage->service_price = $request->service_price;
                $otherPackage->creator_id = $user;
                $otherPackage->updater_id = $user;
                $otherPackage->save();
            }
           

             /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return response()->json([
                'data' => $otherPackage,
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

         $package = PackageMenu::findOrFail($id);
         $package->delete();
    }
}
