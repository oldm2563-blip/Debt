<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified', 'banned'])->name('dashboard');
Route::get('/ban/{user}', [UserController::class, 'ban'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/unban/{user}', [UserController::class, 'unban'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['banned'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['banned'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['banned'])->name('profile.destroy');
    Route::post('/create_coloc', [AccommodationController::class, 'create'])->middleware(['banned']);
    Route::get('/coloc/{token}', [AccommodationController::class, 'coloc'])->middleware(['banned']);
    Route::post('/invite/{coloc}', [AccommodationController::class, 'invite'])->middleware(['banned']);
    Route::get('/request/{token}', [InviteController::class, 'form'])->middleware(['banned']);
    Route::get('/accept/{token}', [InviteController::class, 'accept'])->middleware(['banned']);
    Route::post('/categories/{coloc}', [AccommodationController::class, 'create_category'])->middleware(['banned']);
    Route::post('/quit/{user}/{coloc}', [AccommodationController::class, 'quit'])->middleware(['banned']);
    Route::post('/kick/{user}/{coloc}', [AccommodationController::class, 'kick'])->middleware(['banned']);
    Route::post('/cancel/{coloc}', [AccommodationController::class, 'cancel'])->middleware(['banned']);
    Route::post('/expenses/{coloc}', [ExpenseController::class, 'create_expense'])->middleware(['banned']);
    Route::post('/pay/{id}/{exs_id}', [PaymentController::class, 'pay'])->middleware(['banned']);
    Route::get('/admin/dashboard', [AdminController::class, 'admin'])->middleware(['admin']);
});

require __DIR__.'/auth.php';
