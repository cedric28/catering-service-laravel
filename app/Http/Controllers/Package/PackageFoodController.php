<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PackageMenu;
use Carbon\Carbon;
use App\Log;
use Validator;

class PackageFoodController extends Controller
{
    public function addFood(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $messages = [
                'category_id.required' => 'The Food Menu Category field is required.',
                'category_id.unique' => 'The Food Menu Category has already been taken',
                'package_id.required' => 'The Package ID is required.',
            ];

            $validator = Validator::make($request->all(), [
                // 'category_id' => 'required|integer',
                'category_id' => 'required|integer|unique:package_menus,category_id,' . $request->food_id . ',id,package_id,' . $request->package_id,
                'package_id' => 'required|integer',

            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }

            $user = \Auth::user()->id;

            if ($request->food_id) {

                $foodPackage = PackageMenu::find($request->food_id);
                $foodPackage->category_id = $request->category_id;
                $foodPackage->updater_id = $user;
                $foodPackage->save();

                $log = new Log();
                $log->log = "User " . \Auth::user()->email . " update package food at " . Carbon::now();
                $log->creator_id =  \Auth::user()->id;
                $log->updater_id =  \Auth::user()->id;
                $log->save();
            } else {
                $foodPackage = new PackageMenu();
                $foodPackage->package_id = $request->package_id;
                $foodPackage->category_id = $request->category_id;
                $foodPackage->creator_id = $user;
                $foodPackage->updater_id = $user;
                $foodPackage->save();

                $log = new Log();
                $log->log = "User " . \Auth::user()->email . " create package food at " . Carbon::now();
                $log->creator_id =  \Auth::user()->id;
                $log->updater_id =  \Auth::user()->id;
                $log->save();
            }


            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return response()->json([
                'data' => $foodPackage,
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

        $log = new Log();
        $log->log = "User " . \Auth::user()->email . " delete package food at " . Carbon::now();
        $log->creator_id =  \Auth::user()->id;
        $log->updater_id =  \Auth::user()->id;
        $log->save();
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

            $package = PackageMenu::onlyTrashed()->findOrFail($id);

            /* Restore package */
            $package->restore();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " restore package food at " . Carbon::now();
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
