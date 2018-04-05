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
	return view('dashboard.index');
});

Route::get('dashboard', function () {
	return view('dashboard.index');
});

Route::get('perfis', function () {
	return view('dashboard.profiles');
});
Route::get('perfis', 'ProfilesController@index')->name('perfis');

// Route::get('perfis', 'ProfilesController@index')->name('signup')->middleware('checkguest');

Route::get('perfis/novo', 'ProfilesController@create');
Route::post('perfis/novo', 'ProfilesController@store');
Route::get('perfis/{id}/visualizar', 'ProfilesController@show');
Route::get('perfis/{id}/editar', 'ProfilesController@edit');
Route::post('perfis/{id}/editar', 'ProfilesController@update');
Route::get('perfis/{id}/remover', 'ProfilesController@destroy');

Route::get('example', function () {
	return view('example');
});
