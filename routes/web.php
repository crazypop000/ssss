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
use App\Events\MessagePosted;

Route::get('/', function () {
    return view('main');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index');

Route::post('/users', 'UserController@create');

Route::post('/editUser', 'UserController@edit');

Route::get('/getMaterials', 'MaterialController@index');

Route::post('/createMaterials', 'MaterialController@create');

Route::post('/editMaterials', 'MaterialController@edit');

Route::post('/exportMaterial', 'MaterialController@export');

Route::post('/deleteMaterial', 'MaterialController@delete');

Route::match(['get', 'post'], '/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/currentUser', function() {
	return Auth::user()->load('roles');
});

Route::get('/historyImportExport', 'ImportExportController@index');

Route::get('/getAllTools', 'ToolController@index');

Route::post('/tools', 'ToolController@store');

Route::post('/updateTool', 'ToolController@update');

Route::post('/deleteTool', 'ToolController@destroy');

Route::get('/send', 'HomeController@send');

Route::get('/{any?}', function() {
	return view('main');
})->where('any', '^(.*)\/?$')->name('main');


