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
    Route::get('depo', 'DepoController@index')->name('depo');
    Route::group(['prefix' => 'depo', 'as'=>'depo.'], function () {
        Route::post('datatable-data', 'DepoController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'DepoController@store_or_update_data')->name('store.or.update');
        Route::post('view', 'DepoController@view')->name('view');
        Route::post('edit', 'DepoController@edit')->name('edit');
        Route::post('delete', 'DepoController@delete')->name('delete');
        Route::post('bulk-delete', 'DepoController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'DepoController@change_status')->name('change.status');
        Route::get('previous-balance/{id}', 'DepoController@previous_balance');
        //Ledger Route
        Route::get('ledger', 'DepoLedgerController@index')->name('ledger');
        Route::post('ledger/datatable-data', 'DepoLedgerController@get_datatable_data')->name('ledger.datatable.data');
    });
    Route::get('area-wise-depo-list/{area_id}', 'DepoController@area_wise_depo_list');

    //Depo Advance Routes
    Route::get('depo-advance', 'DepoAdvanceController@index')->name('depo.advance');
    Route::group(['prefix' => 'depo-advance', 'as'=>'depo.advance.'], function () {
        Route::post('datatable-data', 'DepoAdvanceController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'DepoAdvanceController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'DepoAdvanceController@edit')->name('edit');
        Route::post('delete', 'DepoAdvanceController@delete')->name('delete');
        Route::post('bulk-delete', 'DepoAdvanceController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'DepoAdvanceController@change_status')->name('change.status');
    });
});
