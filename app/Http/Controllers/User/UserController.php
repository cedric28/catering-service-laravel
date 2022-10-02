<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\JobType;
use Validator, Hash, DB, Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //prevent other user to access to this page
        $this->authorize("isHeadStaffOrAdmin");

        $users = User::all();

        return view('user.index', [
            'users' => $users
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
        $this->authorize("isHeadStaffOrAdmin");

        $roles = Role::all();
        $job_types = JobType::all();

        return view("user.create", [
            'roles' => $roles,
            'job_types' => $job_types
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
        $this->authorize("isHeadStaffOrAdmin");
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'role_id' => 'required|integer',
                'job_type_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->job_type_id = $request->job_type_id;
            $user->save();
            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('users.create')
                ->with('successMsg', 'User Data Save Successful');
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
        $this->authorize("isHeadStaffOrAdmin");

        $user = User::with('role')->findOrFail($id);

        return view('user.show', [
            'user' => $user
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
        //prevent other user to access to this page
        $this->authorize("isHeadStaffOrAdmin");

        $user = User::withTrashed()->findOrFail($id);
        $roles = Role::all();
        $job_types = JobType::all();


        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'job_types' => $job_types
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
        $this->authorize("isHeadStaffOrAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            $user = User::withTrashed()->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'same:confirm-password',
                'role_id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            if (!$request->password == '') {
                $user->password = bcrypt($request->password);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('users.edit', $user->id)
                ->with('successMsg', 'User Data update Successfully');
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
        $this->authorize("isHeadStaffOrAdmin");

        //delete user
        $user = User::findOrFail($id);
        $user->delete();
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

            $user = User::onlyTrashed()->findOrFail($id);

            /* Restore user */
            $user->restore();


            \DB::commit();
            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    public function viewProfile()
    {
        $user = \Auth::user();

        return view('user.editprofile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            $user = \Auth::user();

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'same:confirm-password'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            if (!$request->password == '') {
                $user->password = bcrypt($request->password);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return back()->with('successMsg', 'User Data update Successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
