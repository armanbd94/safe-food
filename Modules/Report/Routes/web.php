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
    
    
    //Todays Purchase Report Route
    Route::get('todays-purchase-report', 'TodaysPurchaseReportController@index')->name('todays.purchase.report');
    Route::post('todays-purchase-report-data', 'TodaysPurchaseReportController@report_data')->name('todays.purchase.report.data');

    //Purchase Report Route
    Route::get('purchase-report', 'PurchaseReportController@index')->name('purchase.report');
    Route::post('purchase-report-data', 'PurchaseReportController@report_data')->name('purchase.report.data');

    //Todays Sales Report Route
    Route::get('todays-sales-report', 'TodaysSalesReportController@index')->name('todays.sales.report');
    Route::post('todays-sales-report-data', 'TodaysSalesReportController@report_data')->name('todays.sales.report.data');

    //Sales Report Route
    Route::get('sales-report', 'SalesReportController@index')->name('sales.report');
    Route::post('sales-report-data', 'SalesReportController@report_data')->name('sales.report.data');
    
    //Product Sales Report Route
    Route::get('product-sales-report', 'ProductSalesReportController@index')->name('product.sales.report');
    Route::post('product-sales-report-data', 'ProductSalesReportController@report_data')->name('product.sales.report.data');
    
    //Product Wise Sales Report Route
    Route::get('product-wise-sales-report', 'ProductWiseSalesReportController@index')->name('product.wise.sales.report');
    Route::post('product-wise-sales-report-data', 'ProductWiseSalesReportController@report_data')->name('product.wise.sales.report.data');
   

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
    Route::post('depo-wise-sales-report-data', 'DepoWiseSalesReportController@report_data')->name('depo.wise.sales.report.data');

    //Dealer Wise Sales Report Routes
    Route::get('dealer-wise-sales-report', 'DealerWiseSalesReportController@index')->name('dealer.wise.sales.report');
    Route::post('dealer-wise-sales-report-data', 'DealerWiseSalesReportController@report_data')->name('dealer.wise.sales.report.data');

    //Depo Wise Product Sales Report Routes
    Route::get('depo-wise-product-sales-report', 'DepoWiseProductSalesReportController@index')->name('depo.wise.product.sales.report');
    Route::post('depo-wise-product-sales-report-data', 'DepoWiseProductSalesReportController@report_data')->name('depo.wise.product.sales.report.data');

    //Dealer Wise Product Sales Report Routes
    Route::get('dealer-wise-product-sales-report', 'DealerWiseProductSalesReportController@index')->name('dealer.wise.product.sales.report');
    Route::post('dealer-wise-product-sales-report-data', 'DealerWiseProductSalesReportController@report_data')->name('dealer.wise.product.sales.report.data');


});
