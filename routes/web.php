<?php

use App\Http\Controllers\cancelledInvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home.index');
});

Route::resource('facturacion',InvoiceController::class);


 Route::middleware('auth')->group(function () {
     Route::get('/', function () {
         return view('admin.home.index');
     });
 });



require __DIR__ . '/auth.php';
