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
    Route::get('dealer', 'DealerController@index')->name('dealer');
    Route::group(['prefix' => 'dealer', 'as'=>'dealer.'], function () {
        Route::post('datatable-data', 'DealerController@get_datatable_data')->name('datatable.data');
        Route::post('store-or-update', 'DealerController@store_or_update_data')->name('store.or.update');
        Route::post('edit', 'DealerController@edit')->name('edit');
        Route::post('view', 'DealerController@view')->name('view');
        Route::post('delete', 'DealerController@delete')->name('delete');
        Route::post('bulk-delete', 'DealerController@bulk_delete')->name('bulk.delete');
        Route::post('change-status', 'DealerController@change_status')->name('change.status');

        //Ledger Route
        Route::get('ledger', 'DealerLedgerController@index')->name('ledger');
        Route::post('ledger/datatable-data', 'DealerLedgerController@get_datatable_data')->name('ledger.datatable.data');
    });
});
