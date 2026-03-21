<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Strona do zarządzania sesją - dostępna dla wszystkich
Route::get('/session', function () {
    return view('session');
});

// Routes dostępne dla wszystkich użytkowników (nawet bez roli admin)
Route::middleware(['web'])->group(function () {
    Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
    Route::post('/reset-session', [SessionController::class, 'resetSession'])->name('reset-session');
    Route::get('/auth-status', [SessionController::class, 'checkAuth'])->name('check-auth');
});
