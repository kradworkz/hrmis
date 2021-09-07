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

Route::any('login', 'api_UsersController@login');
Route::any('users', 'api_UsersController@query');
Route::any('users/{id}/save', 'api_UsersController@save');
Route::any('users/{id}/delete', 'api_UsersController@delete');
Route::any('users/{id}/activate', 'api_UsersController@activate');
Route::any('users/checkusername/{id?}', 'api_UsersController@checkusername');
Route::any('signature/{id}', 'api_UsersController@showSignature');
Route::any('picture/{id}', 'api_UsersController@showPicture');
Route::any('attendance/{id}', 'api_UsersController@attendance');
// Route::any('desktop/{id}/{location?}', 'api_UsersController@desktop_time_in')->name('Desktop Time In');
Route::any('dtr/{id}', 'api_UsersController@dtr');

Route::any('charts/attendance/{date}', 'APIController@attendance_chart');

// Report API Routes
Route::any('report/{year}/{module}', 'api_ReportController@report');