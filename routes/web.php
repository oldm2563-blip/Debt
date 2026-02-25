<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/create_coloc', [AccommodationController::class, 'create']);
    Route::get('/coloc/{token}', [AccommodationController::class, 'coloc']);
    Route::post('/invite/{coloc}', [AccommodationController::class, 'invite']);
    Route::get('/request/{token}', [InviteController::class, 'form']);
    Route::get('/accept/{token}', [InviteController::class, 'accept']);
});

require __DIR__.'/auth.php';
