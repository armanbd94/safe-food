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
    //GUest GIft Routes
    Route::get('guest-gift', 'GuestGiftController@index')->name('guest.gift');
    Route::group(['prefix' => 'guest-gift', 'as'=>'guest.gift.'], function () {
        Route::post('datatable-data', 'GuestGiftController@get_datatable_data')->name('datatable.data');
        Route::get('add', 'GuestGiftController@create')->name('add');
        Route::post('store', 'GuestGiftController@store')->name('store');
        Route::get('details/{id}', 'GuestGiftController@show')->name('show');
        Route::get('edit/{id}', 'GuestGiftController@edit')->name('edit');
        Route::post('update', 'GuestGiftController@update')->name('update');
        Route::post('delete', 'GuestGiftController@delete')->name('delete');
        Route::post('bulk-delete', 'GuestGiftController@bulk_delete')->name('bulk.delete');
    });      
});