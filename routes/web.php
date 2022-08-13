<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //if has a user redirect to home page if not redirect to login
    if (Auth::user()) return redirect()->route('home');

    return view('auth.login');
});


// Route::get('/', function () {
//     //if has a user redirect to home page if not redirect to login
//     if (Auth::user()) return redirect()->route('home');

//     return view('welcome');
// });

//register route disable
Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    //Category
    Route::resource('/category', 'Category\CategoryController');
    Route::post('category/fetch/q', 'Category\CategoryFetchController@fetchCategory')->name('activeCategory');
    Route::get('category/destroy/{id}', 'Category\CategoryController@destroy');

    //Roles
    Route::resource('roles', 'Role\RoleController');
    Route::post('roles/fetch/q', 'Role\RoleFetchController@fetchRole')->name('activeRole');
    Route::get('roles/destroy/{id}', 'Role\RoleController@destroy');

    //Users
    Route::resource('users', 'User\UserController');
    Route::get('/profile', 'User\UserController@viewProfile')->name('user-profile');
    Route::patch('/profile-update', 'User\UserController@updateProfile')->name('update-profile');
    Route::post('/users/fetch/q', 'User\UserFetchController@fetchUser')->name('activeUser');
    Route::get('users/destroy/{id}', 'User\UserController@destroy');

    //Inventories
    Route::resource('inventories', 'Inventory\InventoryController');
    Route::post('inventories/fetch/q', 'Inventory\InventoryFetchController@fetchInventory')->name('activeInventory');
    Route::get('inventories/destroy/{id}', 'Inventory\InventoryController@destroy');

    //Inventory Category
    Route::resource('inventory-category', 'Inventory\InventoryCategoryController');
    Route::post('inventory-category/fetch/q', 'Inventory\InventoryFetchController@fetchInventoryCategory')->name('activeInventoryCategory');
    Route::get('inventory-category/destroy/{id}', 'Inventory\InventoryCategoryController@destroy');

    //foods
    Route::resource('foods', 'Food\FoodController');
    Route::post('foods/fetch/q', 'Food\FoodFetchController@fetchFood')->name('activeFood');
    Route::get('foods/destroy/{id}', 'Food\FoodController@destroy');

    //Food Category
    Route::resource('food-category', 'Food\FoodCategoryController');
    Route::post('food-category/fetch/q', 'Food\FoodFetchController@fetchFoodCategory')->name('activeFoodCategory');
    Route::get('food-category/destroy/{id}', 'Food\FoodCategoryController@destroy');

    //packages
    Route::resource('packages', 'Package\PackageController');
    Route::post('packages/fetch/q', 'Package\PackageFetchController@fetchPackage')->name('activePackage');
    Route::get('packages/destroy/{id}', 'Package\PackageController@destroy');

    //package task
    Route::post('packages-task/add-task', 'Package\PackageTaskController@addTask')->name('addTask');
    Route::post('packages-task/fetch/q', 'Package\PackageFetchController@fetchPackageTask')->name('activePackageTask');

    //package food
    Route::post('packages-food/add-food', 'Package\PackageFoodController@addFood')->name('addFood');
    Route::post('packages-food/fetch/q', 'Package\PackageFetchController@fetchPackageFood')->name('activePackageFood');

    //package equipments
    Route::post('packages-equipment/add-equipment', 'Package\PackageEquipmentController@addEquipment')->name('addEquipment');
    Route::post('packages-equipment/fetch/q', 'Package\PackageFetchController@fetchPackageEquipment')->name('activePackageEquipment');

    //package others
    Route::post('packages-other/add-other', 'Package\PackageOtherController@addOther')->name('addOther');
    Route::post('packages-other/fetch/q', 'Package\PackageFetchController@fetchPackageOther')->name('activePackageOther');

    //planner
    Route::resource('planners', 'Planner\PlannerController');
    Route::post('planners/fetch/q', 'Planner\PlannerFetchController@fetchPlanner')->name('activePlanner');
    Route::get('planners/destroy/{id}', 'Planner\PlannerController@destroy');
});
