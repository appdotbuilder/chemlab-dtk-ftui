<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordHelpController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Password Help Routes (public access)
Route::get('/password-help', [PasswordHelpController::class, 'create'])->name('password-help.create');
Route::post('/password-help', [PasswordHelpController::class, 'store'])->name('password-help.store');
Route::get('/ticket/{ticketNumber}', [PasswordHelpController::class, 'show'])->name('ticket.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
