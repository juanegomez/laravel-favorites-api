<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FavoriteController;

// User Routes
Route::post('register', [UsersController::class, 'store']);

// Auth Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

// Favorite Routes
Route::middleware('auth:sanctum')->group(function () {
    // Get all favorite API IDs for the authenticated user
    Route::get('favorites/ids', [FavoriteController::class, 'getFavoriteIds'])->name('favorites.ids');
    
    // Standard resource routes
    Route::apiResource('favorite', FavoriteController::class);
});