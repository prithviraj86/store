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

Route::get('/', 'ProductCategoryController@index')->name('home');

Route::get('/product', 'ProductController@index');
Route::get('/product/show/{id}', 'ProductController@show');
Route::get('/product/create', 'ProductController@create');
Route::post('/product/create', 'ProductController@store');
Route::get('/product/edit/{id}', 'ProductController@edit');
Route::get('/product/delete/{id}', 'ProductController@destroy');
Route::post('/product/update', 'ProductController@update');
Route::get('/cart', 'CartController@index');
Route::post('/cart/store', 'CartController@store');
Route::post('/cart/update', 'CartController@update');
Route::post('/cart/delete', 'CartController@destroy');
Route::get('/cart/setcart', 'CartController@setCart');
Route::get('/cart/updatelogin', 'CartController@updateOnlogin');
Route::get('/cart/emptys', 'CartController@emptySession');
Route::get('/category', 'CategoryController@create');
Route::get('/category/edit/{id}', 'CategoryController@edit');
Route::get('/category/delete/{id}', 'CategoryController@destroy');

Route::post('/category/store', 'CategoryController@store');
Route::post('/category/update', 'CategoryController@update');
Route::get('/mailable', function () {


    return new App\Mail\SignUp();
});
Auth::routes();
Route::get('/{id}', 'ProductCategoryController@productByCategory');




