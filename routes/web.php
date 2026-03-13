<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::resource('facturacion',InvoiceController::class);


// Route::middleware('auth', 'verified')->group(function () {

//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
