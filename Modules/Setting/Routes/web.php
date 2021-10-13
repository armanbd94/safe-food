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

     //Warehouse Routes
     Route::get('warehouse', 'WarehouseController@index')->name('warehouse');
     Route::group(['prefix' => 'warehouse', 'as'=>'warehouse.'], function () {
         Route::post('datatable-data', 'WarehouseController@get_datatable_data')->name('datatable.data');
         Route::post('store-or-update', 'WarehouseController@store_or_update_data')->name('store.or.update');
         Route::post('edit', 'WarehouseController@edit')->name('edit');
         Route::post('delete', 'WarehouseController@delete')->name('delete');
         Route::post('bulk-delete', 'WarehouseController@bulk_delete')->name('bulk.delete');
         Route::post('change-status', 'WarehouseController@change_status')->name('change.status');
     });
    

    //Customer Group Routes
    Route::get('customer-group', 'CustomerGroupController@index')->name('customer.group');
    Route::group(['prefix' => 'customer-group', 'as'=>'customer.group.'], function () {
        Route::post('datatable-data', 'CustomerGroupController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'CustomerGroupController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'CustomerGroupController@edit')->name('edit');
        Route::post('delete', 'CustomerGroupController@delete')->name('delete');
        Route::post('bulk-delete', 'CustomerGroupController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'CustomerGroupController@change_status')->name('change.status');
    });

    //Labor Bill Routes
    Route::get('labor-bill', 'LaborBillController@index')->name('labor.bill');
    Route::group(['prefix' => 'labor-bill', 'as'=>'labor.bill.'], function () {
        Route::post('datatable-data', 'LaborBillController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'LaborBillController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'LaborBillController@edit')->name('edit');
        Route::post('delete', 'LaborBillController@delete')->name('delete');
        Route::post('bulk-delete', 'LaborBillController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'LaborBillController@change_status')->name('change.status');
        Route::post('labor-list', 'LaborBillController@labor_list')->name('list');
    });

    //Labor Bill Rate Routes
    Route::get('labor-bill-rate', 'LaborBillRateController@index')->name('labor.bill.rate');
    Route::group(['prefix' => 'labor-bill-rate', 'as'=>'labor.bill.rate.'], function () {
        Route::post('datatable-data', 'LaborBillRateController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'LaborBillRateController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'LaborBillRateController@edit')->name('edit');
        Route::post('delete', 'LaborBillRateController@delete')->name('delete');
        Route::post('bulk-delete', 'LaborBillRateController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'LaborBillRateController@change_status')->name('change.status');
        Route::post('list', 'LaborBillRateController@labor_bill_rate_list')->name('list');
    });

    //Labor Bill Rate Routes
    Route::get('bag', 'BagController@index')->name('bag');
    Route::group(['prefix' => 'bag', 'as'=>'bag.'], function () {
        Route::post('datatable-data', 'BagController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'BagController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'BagController@edit')->name('edit');
        Route::post('delete', 'BagController@delete')->name('delete');
        Route::post('bulk-delete', 'BagController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'BagController@change_status')->name('change.status');
    });

});
