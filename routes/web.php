<?php

use Illuminate\Support\Facades\Route;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', function () {
    $msg = "";
    return view('home')->with('datas',$msg);
});

Route::post('/home', 'ImportdataController@index')->name('home');

Route::view('/export', 'export')->name('export');

Route::post('/export', 'ImportdataController@export')->name('exports');

Route::get('/view', 'ImportdataController@view')->name('view');

Route::get('/master', 'ImportdataController@master')->name('master');

