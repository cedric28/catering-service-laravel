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

    return redirect()->route('landing-page');
});

Route::get('/', 'Landing\LandingController@index')->name('landing-page');

//register route disable
Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/home', 'HomeController@index')->name('home');

    //Product 
    Route::resource('/product', 'Product\ProductController')->middleware('can:isAdmin');
    Route::post('product/fetch/q','Product\ProductFetchController@fetchProduct')->name('activeProduct');
    Route::get('product/destroy/{id}', 'Product\ProductController@destroy');

    //Category
    Route::resource('/category', 'Category\CategoryController');
    Route::post('category/fetch/q','Category\CategoryFetchController@fetchCategory')->name('activeCategory');
    Route::get('category/destroy/{id}', 'Category\CategoryController@destroy');
    
});