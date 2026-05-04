<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;

/*
Public Route (tanpa login)
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
Protected Route (WAJIB LOGIN)
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [InvoiceController::class, 'dashboard'])
        ->name('dashboard');

    // Invoice
    Route::resource('invoices', InvoiceController::class);

    // Client
    Route::resource('clients', ClientController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PRINT PDF
    Route::get('/invoices/{id}/print', [InvoiceController::class, 'print'])
    ->name('invoices.print')
    ->middleware('auth');
});

require __DIR__.'/auth.php';