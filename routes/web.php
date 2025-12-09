<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    //Expense Routes
    Route::post('expense', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('dashboard', [ExpenseController::class, 'index'])->name('dashboard');
    Route::get('expense/{expense}', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::patch('expense/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('expense/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__ . '/auth.php';
