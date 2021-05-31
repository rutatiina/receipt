<?php

Route::group(['middleware' => ['web', 'auth', 'tenant', 'service.accounting']], function() {

	Route::prefix('receipts')->group(function () {

        Route::post('debit-accounts', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@debitAccounts')->name('receipts.debit-accounts');
        Route::post('invoices', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@invoices')->name('receipts.invoices');
        Route::post('invoice', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@invoice')->name('receipts.invoice');

        Route::post('export-to-excel', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@exportToExcel');
        Route::post('{id}/approve', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@approve');
        //Route::get('{id}/copy', 'Rutatiina\Receipt\Http\Controllers\ReceiptController@copy'); // to be deleted

        Route::post('on-invoice/create/data', 'Rutatiina\Receipt\Http\Controllers\ReceiptOnInvoiceController@createData'); //todo this is not being used
        Route::resource('on-invoice', 'Rutatiina\Receipt\Http\Controllers\ReceiptOnInvoiceController');

    });

    Route::resource('receipts/settings', 'Rutatiina\Receipt\Http\Controllers\SettingsController');
    Route::resource('receipts', 'Rutatiina\Receipt\Http\Controllers\ReceiptController');

});
