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
    Route::post('/inactive-users/fetch/q', 'User\UserFetchController@fetchInactiveUser')->name('InactiveUser');
    Route::get('users/destroy/{id}', 'User\UserController@destroy');
    Route::get('users/restore/{id}', 'User\UserController@restore');


    Route::resource('my-tasks', 'User\MyTaskController');


    //TASK USERS
    Route::post('/users-task-staff/fetch/q', 'User\UserFetchController@fetchUserTaskStaff')->name('activeUserTaskStaff');
    Route::post('/users-staffing/fetch/q', 'User\UserFetchController@fetchUserStaffing')->name('activeUserStaffing');

    //Inventories
    Route::resource('inventories', 'Inventory\InventoryController');
    Route::post('inventories/fetch/q', 'Inventory\InventoryFetchController@fetchInventory')->name('activeInventory');
    Route::post('inventories-v2/fetch/q', 'Inventory\InventoryFetchController@fetchInventoryV2')->name('activeInventoryV2');
    Route::post('inactive-inventories/fetch/q', 'Inventory\InventoryFetchController@fetchInactiveInventory')->name('InactiveInventory');
    Route::post('inactive-inventories-v2/fetch/q', 'Inventory\InventoryFetchController@fetchInactiveInventoryV2')->name('InactiveInventoryV2');
    Route::get('inventories/destroy/{id}', 'Inventory\InventoryController@destroy');
    Route::get('inventories/restore/{id}', 'Inventory\InventoryController@restore');

    //Inventory Category
    Route::resource('inventory-category', 'Inventory\InventoryCategoryController');
    Route::post('inventory-category/fetch/q', 'Inventory\InventoryFetchController@fetchInventoryCategory')->name('activeInventoryCategory');
    Route::post('inactive-inventory-category/fetch/q', 'Inventory\InventoryFetchController@fetchInactiveInventoryCategory')->name('InactiveInventoryCategory');
    Route::get('inventory-category/destroy/{id}', 'Inventory\InventoryCategoryController@destroy');
    Route::get('inventory-category/restore/{id}', 'Inventory\InventoryCategoryController@restore');

    //foods
    Route::resource('foods', 'Food\FoodController');
    Route::post('foods/fetch/q', 'Food\FoodFetchController@fetchFood')->name('activeFood');
    Route::post('inactive-foods/fetch/q', 'Food\FoodFetchController@fetchInactiveFood')->name('InactiveFood');
    Route::get('foods/destroy/{id}', 'Food\FoodController@destroy');
    Route::get('foods/restore/{id}', 'Food\FoodController@restore');

    //Food Category
    Route::resource('food-category', 'Food\FoodCategoryController');
    Route::post('food-category/fetch/q', 'Food\FoodFetchController@fetchFoodCategory')->name('activeFoodCategory');
    Route::post('inactive-food-category/fetch/q', 'Food\FoodFetchController@fetchInactiveFoodCategory')->name('InactiveFoodCategory');
    Route::get('food-category/destroy/{id}', 'Food\FoodCategoryController@destroy');
    Route::get('food-category/restore/{id}', 'Food\FoodCategoryController@restore');

    //packages
    Route::resource('packages', 'Package\PackageController');
    Route::post('packages/fetch/q', 'Package\PackageFetchController@fetchPackage')->name('activePackage');
    Route::post('inactive-packages/fetch/q', 'Package\PackageFetchController@fetchInactivePackage')->name('InactivePackage');
    Route::get('packages/destroy/{id}', 'Package\PackageController@destroy');
    Route::get('packages/restore/{id}', 'Package\PackageController@restore');

    Route::get('/packages-show/{id}', 'Package\PackageController@showPackage')->name('showPackage');

    //package task
    Route::post('packages-task/add-task', 'Package\PackageTaskController@addTask')->name('addTask');
    Route::get('packages-task/destroy/{id}', 'Package\PackageTaskController@destroy');
    Route::get('packages-task/restore/{id}', 'Package\PackageTaskController@restore');
    Route::post('packages-task/fetch/q', 'Package\PackageFetchController@fetchPackageTask')->name('activePackageTask');
    Route::post('inactive-packages-task/fetch/q', 'Package\PackageFetchController@fetchInactivePackageTask')->name('InactivePackageTask');



    //package food
    Route::post('packages-food/add-food', 'Package\PackageFoodController@addFood')->name('addFood');
    Route::get('packages-food/destroy/{id}', 'Package\PackageFoodController@destroy');
    Route::post('packages-food/fetch/q', 'Package\PackageFetchController@fetchPackageFood')->name('activePackageFood');
    Route::get('packages-food/restore/{id}', 'Package\PackageFoodController@restore');
    Route::post('inactive-packages-food/fetch/q', 'Package\PackageFetchController@fetchInactivePackageFood')->name('InactivePackageFood');

    //package equipments
    Route::post('packages-equipment/add-equipment', 'Package\PackageEquipmentController@addEquipment')->name('addEquipment');
    Route::get('packages-equipment/destroy/{id}', 'Package\PackageEquipmentController@destroy');
    Route::post('packages-equipment/fetch/q', 'Package\PackageFetchController@fetchPackageEquipment')->name('activePackageEquipment');
    Route::post('inactive-packages-equipment/fetch/q', 'Package\PackageFetchController@fetchInactivePackageEquipment')->name('InactivePackageEquipment');
    Route::get('packages-equipment/restore/{id}', 'Package\PackageEquipmentController@restore');

    //package others
    Route::post('packages-other/add-other', 'Package\PackageOtherController@addOther')->name('addOther');
    Route::get('packages-other/destroy/{id}', 'Package\PackageOtherController@destroy');
    Route::post('packages-other/fetch/q', 'Package\PackageFetchController@fetchPackageOther')->name('activePackageOther');
    Route::post('inactive-packages-other/fetch/q', 'Package\PackageFetchController@fetchInactivePackageOther')->name('InactivePackageOther');
    Route::get('packages-other/restore/{id}', 'Package\PackageOtherController@restore');

    //planner
    Route::resource('planners', 'Planner\PlannerController');
    Route::post('planners/store-food', 'Planner\PlannerController@storeFood')->name('storeFood');
    Route::post('planners/store-task', 'Planner\PlannerController@storeTask')->name('storeTask');
    Route::post('planners/update-task', 'Planner\PlannerController@updateTask')->name('updateTask');
    Route::post('planners/store-task-staff', 'Planner\PlannerController@storeTaskStaff')->name('storeTaskStaff');
    Route::post('planners/destroy-task', 'Planner\PlannerController@destroyTask')->name('destroyTask');
    Route::post('planners/destroy-task-staff', 'Planner\PlannerController@destroyTaskStaff')->name('destroyTaskStaff');
    Route::post('planners/store-equipment', 'Planner\PlannerController@storeEquipment')->name('storeEquipment');
    Route::post('planners/update-equipment', 'Planner\PlannerController@updateEquipment')->name('updateEquipment');
    Route::post('planners/destroy-equipment', 'Planner\PlannerController@destroyEquipment')->name('destroyEquipment');
    Route::post('planners/store-other', 'Planner\PlannerController@storeOther')->name('storeOther');
    Route::post('planners/destroy-other', 'Planner\PlannerController@destroyOther')->name('destroyOther');
    Route::post('planners/store-staffing', 'Planner\PlannerController@storeStaffing')->name('storeStaffing');
    Route::post('planners/destroy-staffing', 'Planner\PlannerController@destroyStaffing')->name('destroyStaffing');
    Route::post('planners/change-attendace-staffing', 'Planner\PlannerController@changeAttendanaceStaffing')->name('changeAttendanaceStaffing');
    Route::post('planners/store-time-table', 'Planner\PlannerController@storeTimeTable')->name('storeTimeTable');
    Route::post('planners/update-time-table', 'Planner\PlannerController@updateTimeTable')->name('updateTimeTable');
    Route::post('planners/destroy-time-table', 'Planner\PlannerController@destroyTimeTable')->name('destroyTimeTable');
    Route::post('planners/store-payment', 'Planner\PlannerController@storePayment')->name('storePayment');
    Route::post('planners/destroy-payment', 'Planner\PlannerController@destroyPayment')->name('destroyPayment');
    Route::get('/planners-show/{id}', 'Planner\PlannerController@showPlanner')->name('showPlanner');
    //fetch
    Route::post('planners-task-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerTask')->name('activePlannerTask');
    Route::post('planners-task-staff-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerTaskStaff')->name('activePlannerTaskStaff');
    Route::post('planners-equipment-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerEquipment')->name('activePlannerEquipment');
    Route::post('planners-other-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerOther')->name('activePlannerOther');
    Route::post('planners-staffing-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerStaffing')->name('activePlannerStaffing');
    Route::post('planners-time-table-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerTimeTable')->name('activePlannerTimeTable');
    Route::post('planners-payment-lists/fetch/q', 'Planner\PlannerDetailsFetchController@fetchPlannerPayments')->name('activePlannerPayments');

    Route::post('pending-planners/fetch/q', 'Planner\PlannerFetchController@fetchPendingPlanner')->name('activePendingPlanner');
    Route::post('ongoing-planners/fetch/q', 'Planner\PlannerFetchController@fetchOnGoingPlanner')->name('activeOnGoingPlanner');
    Route::post('done-planners/fetch/q', 'Planner\PlannerFetchController@fetchDonePlanner')->name('activeDonePlanner');
    Route::post('inactive-planners/fetch/q', 'Planner\PlannerFetchController@fetchInActivePlanner')->name('inActivePlanner');
    Route::get('planners/destroy/{id}', 'Planner\PlannerController@destroy');
    Route::get('planners/restore/{id}', 'Planner\PlannerController@restore');


    //Reports
    Route::get('revenue-report-monthly', 'Report\RevenueController@revenueMonthly')->name('revenueMonthly');
    Route::get('revenue-report-yearly', 'Report\RevenueController@revenueYearly')->name('revenueYearly');
    Route::get('user-activities-report-monthly', 'Report\UserActivityController@usersActiveTracker')->name('usersActiveTracker');


    //PDF
    Route::get('invoice/{id}', 'PDF\PDFController@generateInvoice')->name('generateInvoice');
    Route::get('contract/{id}', 'PDF\PDFController@generateContract')->name('generateContract');
    Route::get('generate-pdf-monthly-sales', 'PDF\PDFController@generateMonthlyRevenue')->name('generateMonthlyRevenue');
    Route::get('print-monthly-sales', 'PDF\PDFController@printMonthlyRevenue')->name('printMonthlyRevenue');
    Route::get('generate-pdf-yearly-sales', 'PDF\PDFController@generateYearlyRevenue')->name('generateYearlyRevenue');
    Route::get('print-yearly-sales', 'PDF\PDFController@printYearlyRevenue')->name('printYearlyRevenue');
    Route::get('print-beo/{id}', 'PDF\PDFController@printBEO')->name('printBEO');

    Route::get('generate-pdf-employee-activities', 'PDF\PDFController@generateEmployeeActivity')->name('generateEmployeeActivity');
    Route::get('print-employee-activities', 'PDF\PDFController@printEmployeeActivity')->name('printEmployeeActivity');


    //Logs
    Route::post('logs/fetch/q', 'Logs\LogController@fetchLogs')->name('activityLogs');

    //Logs
    Route::resource('logs', 'Logs\LogController');
});
