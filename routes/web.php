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
    return view('welcome');
});

Route::get('/print_summary/{month}/{year}/{branch_id}','ServiceController@print_summary');
Route::get('/print_contract/{contract_id}/{branch_id}','ServiceController@print_contract');

