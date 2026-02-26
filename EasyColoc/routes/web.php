<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettlementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Exports\UsersExport;
use App\Http\Controllers\UserController;
use Maatwebsite\Excel\Facades\Excel;

require __DIR__.'/auth.php';


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $colocation = auth()->user()->colocations()->wherePivot('status', 'joined')->first();
    return view('dashboard', compact('colocation'));
})->middleware(['auth', 'verified'])->name('dashboard');

// ==== Auth ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('colocations', ColocationController::class);
    Route::resource('categories', CategoryController::class)->only(['index', 'store']);
    
    Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'destroy']);
    Route::resource('settlements', SettlementController::class)->only(['index']);
    Route::patch('settlements/{settlement}/pay', [SettlementController::class, 'markAsPayed'])->name('settlements.pay');

    Route::get('/invitation/accept/{token}', [UserController::class, 'acceptInvitation'])->name('acceptInvitation');
});

// ======= Admin =======

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/users/{id}/ban',[AdminController::class, 'ban'])->name('admin.ban');
    Route::patch('/admin/users/{id}/unban',[AdminController::class, 'unban'])->name('admin.unban');
    Route::get('/export-users', function () {
         return Excel::download(new UsersExport, 'users.xlsx');
         })->name('admin.export');
});


// ======== Membre ========
Route::middleware(['auth', 'membre'])->group(function () {
    Route::post('/colocation/quitter', [ColocationController::class, 'quitter'])
         ->name('colocation.quitter');
});

// ======= Owner ======
Route::middleware(['auth', 'owner'])->group(function () {
    Route::post('/colocation/invite',  [UserController::class, 'send'])->name('colocation.invite');
    Route::delete('/colocation/{id}',  [ColocationController::class, 'destroy'])->name('colocation.cancel');
});
