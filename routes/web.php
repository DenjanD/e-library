<?php

use Illuminate\Http\Request;
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

Route::get('/', function (Request $request) {
    if ($request->session()->has('logged')) {
        return redirect('home');
    } else {
        return view('login');
    }
});

Route::post('auth', 'LoginController@auth');

Route::get('home', 'LoginController@home');
Route::get('search', 'BukuController@search');
Route::get('details/{id}', 'BukuController@details');

Route::post('transaction', 'TransaksiController@add');
Route::post('transaction/update', 'TransaksiController@update');
Route::post('transaction/verify', 'TransaksiController@verify');

Route::get('myorder', 'TransaksiController@getUsers');

Route::get('logout', 'LoginController@logout');
