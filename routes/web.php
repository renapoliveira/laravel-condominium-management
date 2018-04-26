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
})->middleware('checkuser');

Route::get('dashboard', function () {
	return view('dashboard.index');
})->middleware('checkuser');

Route::get('perfis', 'ProfilesController@index')->name('perfis')->middleware('checkuser');
Route::get('perfis/novo', 'ProfilesController@create')->middleware('checkuser');
Route::post('perfis/novo', 'ProfilesController@store')->middleware('checkuser');
Route::get('perfis/{id}/visualizar', 'ProfilesController@show')->middleware('checkuser');
Route::get('perfis/{id}/editar', 'ProfilesController@edit')->middleware('checkuser');
Route::post('perfis/{id}/editar', 'ProfilesController@update')->middleware('checkuser');
Route::get('perfis/{id}/remover', 'ProfilesController@destroy')->middleware('checkuser');

Route::get('usuarios', 'UsersController@index')->name('usuarios')->middleware('checkuser');
Route::get('usuarios/novo', 'UsersController@create')->middleware('checkuser');
Route::post('usuarios/novo', 'UsersController@store')->middleware('checkuser');
Route::get('usuarios/{id}/visualizar', 'UsersController@show')->middleware('checkuser');
Route::get('usuarios/{id}/editar', 'UsersController@edit')->middleware('checkuser');
Route::post('usuarios/{id}/editar', 'UsersController@update')->middleware('checkuser');
Route::get('usuarios/{id}/remover', 'UsersController@destroy')->middleware('checkuser');
Route::get('usuarios/{id}/nova_senha', 'UsersController@editPassword')->middleware('checkuser');
Route::post('usuarios/{id}/nova_senha', 'UsersController@updatePassword')->middleware('checkuser');

Route::get('blocos', 'UnitsController@index')->name('blocos')->middleware('checkuser');
Route::post('blocos', 'UnitsController@store')->middleware('checkuser');


Route::get('login', 'LoginController@index')->middleware('checkguest');
Route::post('login', 'LoginController@login')->middleware('checkguest');
Route::get('logout', 'LoginController@logout')->middleware('checkuser');

Route::get('example', function () {
	return view('example');
});
