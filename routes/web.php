<?php

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

Route::get('/', 'ProductController@index')->name('home');
Route::get('/product/show/{id}', 'ProductController@show');
Route::get('/product/create', 'ProductController@create')->middleware('auth');
Route::post('/product/create', 'ProductController@store')->middleware('auth');

Route::get('/cart', 'CartController@index');
Route::post('/cart/store', 'CartController@store');
Route::post('/cart/update', 'CartController@update');
Route::post('/cart/delete', 'CartController@destroy');

Auth::routes();


