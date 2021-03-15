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
    $croaks = App\Croak::all();
    return view('index', compact('croaks'));
});

Route::get('apitest', function(){
  return view('apitest');
});

Route::post('pfdb', 'FileController@populateDB');
Route::get('populatefdb', function(){
	return view('populate_files');
});

Route::get('c/{id}', function($id){
  $c = App\Croak::find($id);
  return view('c', compact('c'));
});

Route::get('phptest', function(){
	return view('phptest');
});

Route::get('about', function(){
  return view('about');
});

Route::get('map', 'CroakController@map');

//Route::get('/', 'HomeController@index');

Auth::routes();

//Route::Resource('croaks', 'CroakController');
