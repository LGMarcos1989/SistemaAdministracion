<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\typeRateController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/', function () {
        return view('admin.home.index');
    })->name('home.index');

    Route::resource('clientes', ClientController::class)->names('clientes');
    Route::resource('facturacion', InvoiceController::class)->names('facturacion');
    Route::resource('staff', PersonController::class)->names('staff');
    Route::resource('impuestos', typeRateController::class)->names('impuestos');
    Route::resource('usertype', UserTypeController::class )->names('usertype');
    // Route::resource('facturacion', )->names('facturacion')
    // Route::resource('roles', )->names('roles')
});
