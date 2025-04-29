<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AppointmentController,
    ClientController,
    PaymentController,
    TrainerController,
    TrainingProgramController
};

Route::resource('appointments', AppointmentController::class);
Route::resource('clients', ClientController::class);
Route::resource('payments', PaymentController::class);
Route::resource('trainers', TrainerController::class);
Route::resource('training-programs', TrainingProgramController::class);

Route::get('/', function () {
    return 'Laravel працює! Вітаємо!';
});
