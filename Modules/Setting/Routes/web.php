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
    Route::get('dealer-group', 'DealerGroupController@index')->name('dealer.group');
    Route::group(['prefix' => 'dealer-group', 'as'=>'dealer.group.'], function () {
        Route::post('datatable-data', 'DealerGroupController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'DealerGroupController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'DealerGroupController@edit')->name('edit');
        Route::post('delete', 'DealerGroupController@delete')->name('delete');
        Route::post('bulk-delete', 'DealerGroupController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'DealerGroupController@change_status')->name('change.status');
    });


});
