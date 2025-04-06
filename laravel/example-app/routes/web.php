<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', [testController::class, 'test']);
Route::get('/test/create', [TestController::class, 'create']);
Route::get('/test/{id}', [TestController::class, 'read']);
Route::put('/test/update/{id}', [TestController::class, 'update']);
Route::delete('/test/delete/{id}', [TestController::class, 'delete']);