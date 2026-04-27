<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;


use App\Http\Controllers\InvoiceController;

Route::resource('invoices', InvoiceController::class);

Route::resource('clients', ClientController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [InvoiceController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::resource('invoices', InvoiceController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
