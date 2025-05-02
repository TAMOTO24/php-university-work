<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('admin-dashboard', [UserController::class, 'adminDashboard'])->middleware('role:Admin');
    Route::get('manager-dashboard', [UserController::class, 'managerDashboard'])->middleware('role:Manager');
    Route::get('client-dashboard', [UserController::class, 'clientDashboard'])->middleware('role:Client');
});

