<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::resource('transactions', TransactionController::class);
    Route::resource('categories', CategoryController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    Route::get('/reports/by-category', [ReportController::class, 'byCategory'])->name('report.by-category');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('report.export-pdf');

    // Admin Routes
    Route::prefix('admin')->middleware(['auth', 'verified', \App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}/transactions', [AdminController::class, 'userTransactions'])->name('admin.user-transactions');
        Route::get('/transactions', [AdminController::class, 'allTransactions'])->name('admin.transactions');
        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    });
});

require __DIR__.'/auth.php';

