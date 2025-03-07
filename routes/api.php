<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});



// Global authentication for API routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Other API routes requiring general authentication go here...

    // Admin-only routes
    Route::middleware('CheckRole:admin')->group(function () {
        // Routes accessible only by admins (e.g., POST /books, PUT /books/{id},DELETE /books/{id} )
        // Bookstore API routes
        Route::resource('books', BookController::class)->except(['create', 'edit']);
    });
});
