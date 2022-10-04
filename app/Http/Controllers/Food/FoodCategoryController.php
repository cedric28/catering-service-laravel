<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DishCategory;
use App\Category;
use Carbon\Carbon;
use App\Log;
use Validator;

class FoodCategoryController extends Controller
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

        $food_categories = Category::all();

        return view('food.category.index', [
            'food_categories' => $food_categories
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

        $dish_categories = DishCategory::all();

        return view('food.category.create')->with([
            'dish_categories' => $dish_categories
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
                'name' => 'required|unique:categories,name',
                'dish_category_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $food_category = new Category();
            $food_category->name = $request->name;
            $food_category->dish_category_id = $request->dish_category_id;
            $food_category->creator_id = $user;
            $food_category->updater_id = $user;
            $food_category->save();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " create food category " . $food_category->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();


            return redirect()->route('food-category.create')
                ->with('successMsg', 'Food Category created successfully');
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

        $food_category = Category::findOrFail($id);

        return view('food.category.show')->with(['food_category' => $food_category]);
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

        $food_category = Category::findOrFail($id);

        $dish_categories = DishCategory::all();

        return view('food.category.edit')->with([
            'food_category' => $food_category,
            'dish_categories' => $dish_categories
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

            $food_category = Category::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories,name,' . $food_category->id,
                'dish_category_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            $food_category->name = $request->name;
            $food_category->dish_category_id = $request->dish_category_id;
            $food_category->updater_id = $user;
            $food_category->save();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " edit food category " . $food_category->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            /*
        | @End Transaction
        |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('food-category.edit', $food_category->id)
                ->with('successMsg', 'Food Category updated successfully');
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

        $food_category = Category::findOrFail($id);
        $food_category->delete();

        $log = new Log();
        $log->log = "User " . \Auth::user()->email . " delete food category " . $food_category->name . " at " . Carbon::now();
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

            $food_category = Category::onlyTrashed()->findOrFail($id);

            /* Restore food_category */
            $food_category->restore();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " restore food category " . $food_category->name . " at " . Carbon::now();
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
