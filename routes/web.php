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
    return view('welcome');
});

Auth::routes();

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/updateuser', 'UserController@updateuser')->name('updateuser');
Route::get('/user/index', 'UserController@index')->name('user.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edituser')->name('user.edit');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/home', 'IncidentController@index')->name('home');
Route::post('/incident/create', 'IncidentController@create')->name('incident.create');

Route::get('/incident/search', 'IncidentController@search')->name('incident.search');
Route::post('/incident/search', 'IncidentController@search')->name('incident.search');
Route::get('/incident/delete/{id}', 'IncidentController@delete')->name('incident.delete');
Route::post('/incident/response', 'IncidentController@response')->name('incident.response');

Route::get('/kdb/index', 'KdbController@index')->name('kdb.index');
Route::post('/kdb/index', 'KdbController@index')->name('kdb.index');
Route::get('/kdb/solution/{id}', 'KdbController@solution')->name('kdb.solution');
Route::get('/kdb/create', 'KdbController@create')->name('kdb.create');
Route::get('/kdb/delete/{id}', 'KdbController@delete')->name('kdb.delete');
Route::get('/kdb/edit/{id}', 'KdbController@edit')->name('kdb.edit');
Route::post('/kdb/update', 'KdbController@update')->name('kdb.update');
Route::post('/kdb/save', 'KdbController@save')->name('kdb.save');
