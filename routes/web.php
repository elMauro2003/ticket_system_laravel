<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ResponseController;

// Página de inicio
Route::get('/', function () {
    return view('home');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // CRUD de Tickets
    Route::resource('tickets', TicketController::class);
    
    // Rutas para Responses
    Route::post('/tickets/{ticket}/responses', [ResponseController::class, 'store'])
        ->name('responses.store');
    Route::get('/tickets/{ticket}/responses/{response}/edit', [ResponseController::class, 'edit'])
        ->name('responses.edit');
    Route::put('/tickets/{ticket}/responses/{response}', [ResponseController::class, 'update'])
        ->name('responses.update');
    Route::delete('/tickets/{ticket}/responses/{response}', [ResponseController::class, 'destroy'])
        ->name('responses.destroy');
});