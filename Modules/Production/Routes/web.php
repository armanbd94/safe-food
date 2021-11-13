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

    Route::get('todays-production-order-sheet', 'ProductionOrderSheetController@create');
    Route::get('production-order-sheet', 'ProductionOrderSheetController@index')->name('production.order.sheet');
    Route::group(['prefix' => 'production-order-sheet', 'as'=>'production.order.sheet.'], function () {
        Route::post('datatable-data', 'ProductionOrderSheetController@get_datatable_data')->name('datatable.data');
        Route::get('view/{id}', 'ProductionOrderSheetController@show')->name('view');
        Route::post('store', 'ProductionOrderSheetController@store')->name('store');
        Route::post('delete', 'ProductionOrderSheetController@delete')->name('delete');
        Route::get('generate', 'ProductionOrderSheetController@generate_production_order_sheet')->name('generate');
    });
    Route::get('production-order-challan/{id}', 'ProductionOrderChallanController@index')->name('production.order.challan');
    Route::get('order/depo-bill//{order_sheet_id}/print/{depo_id}', 'ProductionOrderChallanController@depo_invoice');
    Route::get('order/dealer-bill//{order_sheet_id}/print/{dealer_id}', 'ProductionOrderChallanController@dealer_invoice');
});
