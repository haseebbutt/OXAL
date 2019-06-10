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

Route::get('/', function () {
    return redirect('admin');
});

//Auth::routes();

Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/', 'HomeController@index');
	Route::get('reviews', 'UsersController@allReviews');

	Route::group(['prefix' => 'users'], function() {
		Route::get('/', 'UsersController@index');
		Route::get('add', 'UsersController@add');
		Route::post('store', 'UsersController@store');
		Route::get('edit/{id}', 'UsersController@edit');
		Route::post('update/{id}', 'UsersController@update');
		Route::post('delete/{id}', 'UsersController@delete');
		Route::get('reviews/{id}', 'UsersController@reviews');
	});

	Route::group(['prefix' => 'categories'], function() {
		Route::get('/', 'CategoriesController@index');
		Route::get('add', 'CategoriesController@add');
		Route::post('store', 'CategoriesController@store');
		Route::get('edit/{id}', 'CategoriesController@edit');
		Route::post('update/{id}', 'CategoriesController@update');
		Route::post('delete/{id}', 'CategoriesController@delete');
	});

	Route::group(['prefix' => 'products'], function() {
		Route::get('/', 'ProductsController@index');
		Route::get('add', 'ProductsController@add');
		Route::post('store', 'ProductsController@store');
		Route::get('edit/{id}', 'ProductsController@edit');
		Route::post('update/{id}', 'ProductsController@update');
		Route::post('delete/{id}', 'ProductsController@delete');
	});
});
