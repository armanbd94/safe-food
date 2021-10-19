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

Route::group(['middleware' => ['auth']], function () {
    //Adjustment Routes
    Route::get('material-stock-out', 'MaterialStockOutController@index')->name('material.stock.out');
    Route::group(['prefix' => 'material-stock-out', 'as'=>'material.stock.out.'], function () {
        Route::get('create', 'MaterialStockOutController@create')->name('create');
        Route::post('datatable-data', 'MaterialStockOutController@get_datatable_data')->name('datatable.data');
        Route::post('store', 'MaterialStockOutController@store')->name('store');
        Route::post('update', 'MaterialStockOutController@update')->name('update');
        Route::get('edit/{id}', 'MaterialStockOutController@edit')->name('edit');
        Route::get('view/{id}', 'MaterialStockOutController@show')->name('view');
        Route::post('delete', 'MaterialStockOutController@delete')->name('delete');
        Route::post('bulk-delete', 'MaterialStockOutController@bulk_delete')->name('bulk.delete');
        
        //Report
        Route::get('report', 'MaterialStockOutReportController@index')->name('report');
        Route::post('report/datatable-data', 'MaterialStockOutReportController@get_datatable_data')->name('report.datatable.data');
    });
});
