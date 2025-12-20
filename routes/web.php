<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportsController as AdminReportsController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\ListingsController as AdminListingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Listing routes
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::get('/my-listings', [ListingController::class, 'myListings'])->name('listings.my');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    // Report routes
    Route::post('/listings/{listing}/report', [ReportController::class, 'store'])->name('listings.report');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Reports management
    Route::get('/reports', [AdminReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportsController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{report}', [AdminReportsController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [AdminReportsController::class, 'destroy'])->name('reports.destroy');

    // Users management
    Route::get('/users', [AdminUsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUsersController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/ban', [AdminUsersController::class, 'ban'])->name('users.ban');

    // Listings management
    Route::get('/listings', [AdminListingsController::class, 'index'])->name('listings.index');
    Route::get('/listings/deleted', [AdminListingsController::class, 'deleted'])->name('listings.deleted');
    Route::get('/listings/deleted/{id}', [AdminListingsController::class, 'showDeleted'])->name('listings.deleted.show');
    Route::delete('/listings/{listing}', [AdminListingsController::class, 'destroy'])->name('listings.destroy');
});

require __DIR__.'/auth.php';