<?php

use Illuminate\Support\Facades\Route;
use App\importdata;
use App\ibd_po_detail;
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
	$bccnt0=importdata::count();
	$bccnt1=ibd_po_detail::count();
    $msg = "Stock Total :".$bccnt0." | PO Total :".$bccnt1;
    return view('home')->with('datas',$msg);
});

Route::post('/home', 'ImportdataController@index')->name('home');

Route::view('/export', 'export')->name('export');

Route::post('/export', 'ImportdataController@export')->name('exports');