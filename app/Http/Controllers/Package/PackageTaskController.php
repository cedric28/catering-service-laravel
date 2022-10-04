<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PackageTask;
use Carbon\Carbon;
use App\Log;
use Validator;

class PackageTaskController extends Controller
{
    //
    public function addTask(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {

            $messages = [
                'package_id.required' => 'The Package ID field is required.',
                'name.required' => 'The task field name is required.',
                'name.max' => 'The task field name may not be greater than 50 characters.'
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50|unique:package_tasks,name,' . $request->name . ',id,package_id,' . $request->package_id,
                // 'name' => 'required|string|max:50',
                'package_id' => 'required|integer',

            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors()
                ], 422);
            }

            //check current user
            $user = \Auth::user()->id;

            $packageTask = PackageTask::updateOrCreate(
                [
                    'id' => $request->task_id
                ],
                [
                    'name'       => $request->name,
                    'package_id' => $request->package_id,
                    'creator_id' =>  $user,
                    'updater_id' =>  $user
                ]
            );

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " update or create package task " . $packageTask->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return response()->json([
                'data' => $packageTask,
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

        $package = PackageTask::findOrFail($id);
        $package->delete();

        $log = new Log();
        $log->log = "User " . \Auth::user()->email . " delete package task " . $package->name . " at " . Carbon::now();
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

            $package = PackageTask::onlyTrashed()->findOrFail($id);

            /* Restore package */
            $package->restore();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " restore package task " . $package->name . " at " . Carbon::now();
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
