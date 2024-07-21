<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
