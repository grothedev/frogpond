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

use App\Models\Croak;

Route::get('/', function () {
    $croaks = Croak::all()->where('p_id', '==', '0');
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
  $c = Croak::find($id);
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


//Route::Resource('croaks', 'CroakController');
