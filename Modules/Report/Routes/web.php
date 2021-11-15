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
    //Closing Route
    Route::get('closing', 'ClosingReportController@index')->name('closing');
    Route::post('closing-data', 'ClosingReportController@closing_data')->name('closing.data');
    Route::post('closing/store', 'ClosingReportController@store')->name('closing.store');

    //Closing Report Route
    Route::get('closing-report', 'ClosingReportController@report')->name('closing.report');
    Route::post('closing-report/datatable-data', 'ClosingReportController@get_datatable_data')->name('closing.report.datatable.data');
    

    //Today Sales Report Route
    Route::get('today-sales-report', 'TodaySalesReportController@index')->name('today.sales.report');
    Route::post('today-sales-report/datatable-data', 'TodaySalesReportController@get_datatable_data')->name('today.sales.report.datatable.data');

    //Sales Report Route
    Route::get('sales-report', 'SalesReportController@index')->name('sales.report');
    Route::post('sales-report/datatable-data', 'SalesReportController@get_datatable_data')->name('sales.report.datatable.data');
    
    //Product Wise Sales Report Route
    Route::get('product-wise-sales-report', 'ProductWiseSalesReportController@index')->name('product.wise.sales.report');
    Route::post('product-wise-sales-report/datatable-data', 'ProductWiseSalesReportController@get_datatable_data')->name('product.wise.sales.report.datatable.data');
   

    //Warehouse Summary Report Route
    Route::get('warehouse-summary', 'WarehouseSummaryController@index')->name('warehouse.summary');
    Route::post('warehouse-summary/data', 'WarehouseSummaryController@summary_data')->name('warehouse.summary.data');

    //Material Alert Report Route
    Route::get('material-stock-alert-report', 'MaterialStockAlertController@index')->name('material.stock.alert.report');
    Route::post('material-stock-alert-report/datatable-data', 'MaterialStockAlertController@get_datatable_data')->name('material.stock.alert.report.datatable.data');
    
    //Product Alert Report Route
    Route::get('product-stock-alert-report', 'ProductStockAlertController@index')->name('product.stock.alert.report');
    Route::post('product-stock-alert-report/datatable-data', 'ProductStockAlertController@get_datatable_data')->name('product.stock.alert.report.datatable.data');

    //Depo Wise Sales Report Routes
    Route::get('depo-wise-sales-report', 'DepoWiseSalesReportController@index')->name('depo.wise.sales.report');
    Route::post('batch-wise-sales-report-data', 'DepoWiseSalesReportController@report_data')->name('depo.wise.sales.report.data');


});
