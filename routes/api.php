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

Route::post('/login','ApiController@login');
Route::post('/update-user','ApiController@updateUser');
Route::post('/register-client','ApiController@registerClient');
Route::post('/get-live-client','ApiController@getLiveClients');
Route::post('/get-deleted-client','ApiController@getDeletedClients');
Route::post('/delete-live-client','ApiController@deletetLiveClients');
Route::post('/get-all-remarks','ApiController@getAllRemarks');
Route::post('/submit-remarks','ApiController@submitRemark');

