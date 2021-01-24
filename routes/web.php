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

Route::get('/veryadmin', function (Request $request) {
    if ($request->session()->has('administrator')) {
        return view('admin/dashboard');
    } else {
        return view('admin/login');
    }
});

//Admin Routes
Route::post('admin/login', 'AdminController@login');
Route::get('admin/logout', 'AdminController@logout');
Route::get('admin/dashboard', 'AdminController@dashboard');
Route::get('admin/katbchart', 'AdminController@katbchart');
Route::get('admin/transchart', 'AdminController@transchart');

Route::get('admin/katb', 'AdminController@katb');
Route::get('admin/katb/{id}', 'AdminController@katbSpec');
Route::post('admin/katb', 'KategoriBukuController@add');
Route::post('admin/katb/update', 'KategoriBukuController@update');
Route::delete('admin/katb/{id}', 'KategoriBukuController@delete');

Route::get('admin/buku', 'AdminController@buku');
Route::get('admin/buku/{id}', 'AdminController@bukuSpec');
Route::post('admin/buku', 'BukuController@add');
Route::post('admin/buku/update', 'BukuController@update');
Route::delete('admin/buku/{id}', 'BukuController@delete');

Route::get('admin/anggota', 'AdminController@anggota');
Route::get('admin/anggota/{id}', 'AdminController@anggotaSpec');
Route::post('admin/anggota', 'AnggotaController@add');
Route::post('admin/anggota/update', 'AnggotaController@update');
Route::delete('admin/anggota/{id}', 'AnggotaController@delete');

Route::get('admin/transaksi', 'AdminController@transaksi');
Route::get('admin/transaksi/{id}', 'AdminController@transaksiSpec');
Route::post('admin/transaksi/verify', 'TransaksiController@verify');

Route::get('admin/laporan', 'AdminController@laporan');
Route::post('admin/laporan/export', 'AdminController@export');
// ./

Route::get('register', function () {
    return view('register');
});
Route::post('register', 'AnggotaController@add');
Route::post('auth', 'LoginController@auth');

Route::get('home', 'LoginController@home');
Route::get('search', 'BukuController@search');
Route::get('details/{id}', 'BukuController@details');

Route::post('transaction', 'TransaksiController@add');
Route::post('transaction/update', 'TransaksiController@update');
Route::post('transaction/verify', 'TransaksiController@verify');

Route::get('myorder', 'TransaksiController@getUsers');

Route::get('profile', 'AnggotaController@profile');
Route::get('profile/checkpass', 'AnggotaController@checkPass');
Route::post('profile/cpass', 'AnggotaController@update');
Route::post('profile/uppict', 'AnggotaController@update');

Route::get('logout', 'LoginController@logout');
