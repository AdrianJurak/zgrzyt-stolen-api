<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController as AdminLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Tutaj możesz zarejestrować trasy API dla swojej aplikacji. Te trasy
| są ładowane przez RouteServiceProvider i wszystkie zostaną przypisane
| do grupy middleware "api".
|
*/

// --- Trasy publiczne ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/request-account', [AuthController::class, 'requestAccount']);

// --- Trasy chronione (wymagają uwierzytelnienia przez Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/request-account', [AuthController::class, 'requestAccount']);


    // --- Trasy dla zgłoszeń (Tickets) ---
    // Użytkownik widzi tylko swoje, IT/Admin widzą wszystkie (do obsłużenia w kontrolerze/polityce)
    Route::apiResource('tickets', TicketController::class);

    // --- Trasy dla wiadomości (Messages) w ramach zgłoszenia ---
    Route::prefix('tickets/{ticket}')->as('tickets.')->group(function () {
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    });

    // --- Trasy zarządzania użytkownikami (IT/Admin) ---
    Route::middleware('can:access-admin-features')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
    });
});
