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

Route::get('/home', 'ImportdataController@home')->name('home');

Route::post('/home', 'ImportdataController@index')->name('home');

Route::get('/search', 'ImportdataController@search')->name('search');

Route::get('/export', 'ImportdataController@exindex')->name('export');

Route::get('/exports', 'ImportdataController@export')->name('exports');

Route::get('/view', 'ImportdataController@view')->name('view');

Route::get('/master', 'ImportdataController@master')->name('master');

Route::get('/showall', 'ImportdataController@showall')->name('showall');

Route::get('/gettable', 'ImportdataController@gettable')->name('gettable');

