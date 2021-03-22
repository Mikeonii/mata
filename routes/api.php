<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// making a route group
Route::group(['prefix'=>'auth','namespace'=>'Auth'],function(){
    Route::post('signin','SignInController');
    Route::post('signout','SignOutController');
    // return authenticated user information
    Route::get('me','MeController');
});

// List single Service
Route::get('service/{id}','ServiceController@show');
// Create Service
Route::post('service','ServiceController@store');
// Update Service
Route::put('service','ServiceController@store');
// Delete Service
Route::delete('service/{id}','ServiceController@destroy');
// filtered services result
Route::get('services/{branch_id}','ServiceController@filtered');  
// Edit Service Info
Route::put('edit_service_info','ServiceController@edit_service_info');
// Get total Service
Route::post('get_total_service','ServiceController@get_total_service');
// Get filtered payments from mode of payments
Route::get('get_filtered_service/{branch_id}','ServiceController@filtered_service');


// PAYMENTS

// list payments
Route::get('payments','PaymentController@index');
// list single payment
Route::get('payment/{id}','PaymentController@show');
// add payment
Route::post('payment','PaymentController@store');
// update payment
Route::put('payment','PaymentController@store');
// delete payment
Route::delete('payment/{id}','PaymentController@destroy');
// filtered payments result
Route::get('payments/{service_id}','PaymentController@get_single');
// total_collections
Route::get('payments/total_collections/{month}/{year}/{branch_id}','PaymentController@get_total');


Route::get('export_to_excel/{month}/{year}/{branch_id}','PaymentController@export_to_excel');

// add user
Route::post('/add_new_user', 'UsersController@store');