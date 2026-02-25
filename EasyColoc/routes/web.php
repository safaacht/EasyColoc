<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettlementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('colocations', ColocationController::class);
    Route::resource('categories', CategoryController::class)->only(['index', 'store']);
    
    Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
    Route::resource('settlements', SettlementController::class)->only(['index']);
    Route::patch('settlements/{settlement}/pay', [SettlementController::class, 'markAsPayed'])->name('settlements.pay');
});

require __DIR__.'/auth.php';
