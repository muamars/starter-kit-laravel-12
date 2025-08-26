<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProjectController;

// Authentication Routes
Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'apiLogout']);
    Route::get('/user', [AuthController::class, 'apiUser']);

    // Blog API Routes
    Route::middleware('permission:view blogs')->group(function () {
        Route::get('/blogs', [BlogController::class, 'apiIndex']);
        Route::get('/blogs/{blog}', [BlogController::class, 'apiShow']);
    });

    Route::middleware('permission:create blogs')->group(function () {
        Route::post('/blogs', [BlogController::class, 'apiStore']);
    });

    Route::middleware('permission:edit blogs')->group(function () {
        Route::put('/blogs/{blog}', [BlogController::class, 'apiUpdate']);
    });

    Route::middleware('permission:delete blogs')->group(function () {
        Route::delete('/blogs/{blog}', [BlogController::class, 'apiDestroy']);
    });

    // Project API Routes
    Route::middleware('permission:view projects')->group(function () {
        Route::get('/projects', [ProjectController::class, 'apiIndex']);
        Route::get('/projects/{project}', [ProjectController::class, 'apiShow']);
    });

    Route::middleware('permission:create projects')->group(function () {
        Route::post('/projects', [ProjectController::class, 'apiStore']);
    });

    Route::middleware('permission:edit projects')->group(function () {
        Route::put('/projects/{project}', [ProjectController::class, 'apiUpdate']);
    });

    Route::middleware('permission:delete projects')->group(function () {
        Route::delete('/projects/{project}', [ProjectController::class, 'apiDestroy']);
    });
});
