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
});
