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

//Kb APIs
Route::get('kb', 'KategoriBukuController@index');
Route::post('kb', 'KategoriBukuController@add');
Route::post('kb/update', 'KategoriBukuController@update');
Route::delete('kb/{id}', 'KategoriBukuController@delete');
Route::get('admin/katb/{id}', 'AdminController@katbSpec');

//Buku APIs
Route::get('buku', 'BukuController@index');
Route::post('buku', 'BukuController@add');
Route::post('buku/update', 'BukuController@update');
Route::delete('buku/{id}', 'BukuController@delete');

//Anggota APIs
Route::get('anggota', 'AnggotaController@index');
Route::post('anggota', 'AnggotaController@add');
Route::post('anggota/update', 'AnggotaController@update');
Route::delete('anggota/{id}', 'AnggotaController@delete');

//Admin APIs
Route::get('admin', 'AdminController@index');
Route::post('admin', 'AdminController@add');
Route::post('admin/update', 'AdminController@update');
Route::delete('admin/{id}', 'AdminController@delete');

//Transaksi APIs
Route::get('transaksi', 'TransaksiController@index');
Route::post('transaksi', 'TransaksiController@add');
Route::post('transaksi/update', 'TransaksiController@update');
Route::post('transaksi/verify', 'TransaksiController@verify');
