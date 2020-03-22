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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::get('transaksi', 'TransaksiController@transaksi');
Route::get('transaksiall', 'TransaksiController@transaksiAuth')->middleware('jwt.verify');
Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');

Route::middleware(['jwt.verify'])->group(function(){
	Route::post('saldo', 'UserController@saldo');
	Route::post('transaksi', 'TransaksiController@store');
	Route::put('transaksi', 'TransaksiController@update');
});
