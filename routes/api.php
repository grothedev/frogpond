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

Route::get('/', function(){
    return view('api_info');
});

Route::Resource('croaks', 'CroakController');
Route::Resource('files', 'FileController');
Route::Resource('tags', 'TagController');
Route::Resource('votes', 'VoteController');
Route::Resource('reports', 'ReportController');
Route::get('motd', function(){
    return view('motd');
});
Route::post('croaks/report', 'CroakController@report');