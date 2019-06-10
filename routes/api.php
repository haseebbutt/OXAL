<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
	Route::post('register', 'UsersController@register');
	Route::post('login', 'UsersController@login');
	Route::post('social-login', 'UsersController@socialLogin');
	Route::post('check-email', 'UsersController@checkEmail');
	Route::post('get-all-categories', 'CategoriesController@getAllCategories');
	Route::post('get-user-detail', 'UsersController@getUserDetail');
	Route::post('update-user-phone-number-and-send-verification-code', 'UsersController@updateUserPhoneNumberAndSendVerificationCode');
	Route::post('post-ad', 'ProductsController@postAd');
	Route::post('post-business-ad', 'ProductsController@postBusinessAd');
	Route::post('delete-ad', 'ProductsController@deleteAd');
	Route::post('get-all-products', 'ProductsController@getAllProducts');
	Route::post('search-products', 'ProductsController@searchProducts');
	Route::post('get-user-products', 'ProductsController@getUserProducts');
	Route::post('get-featured-products', 'ProductsController@getFeaturedProducts');
	Route::post('get-products-by-category', 'ProductsController@getProductsByCategory');
	Route::post('get-product-detail', 'ProductsController@getProductDetail');
	Route::post('update-user-profile', 'UsersController@updateUserProfile');
	Route::post('add-user-review', 'UsersController@addUserReview');
	Route::post('get-user-reviews', 'UsersController@getUserReviews');
	Route::post('save-product-payment-detail', 'ProductsController@saveProductPaymentDetail');
	Route::get('check-product-payment-status', 'ProductsController@checkProductPaymentStatus');
	Route::get('test-cron-job', 'ProductsController@testCronJob');
	Route::get('getStates','CityController@getStates');
	Route::post('searchCity','CityController@searchCity');


	Route::post('images-test', 'ProductsController@imagesTest');
});

