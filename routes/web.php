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

Route::get('/', 'StoreFrontController@index');
Route::get('/add-to-cart/{id}','StoreFrontController@showProductDetails');
Route::post('/add-to-cart','StoreFrontController@addTocart');
Route::get('/view-cart','StoreFrontController@viewCart');
Route::get('/checkout','StoreFrontController@checkout');
Route::post('/checkout','StoreFrontController@placeOrder');
Route::post('/pay', 'RaveController@initialize')->name('pay');
Route::post('/rave/callback', 'RaveController@callback')->name('callback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('products','ProductsController');
