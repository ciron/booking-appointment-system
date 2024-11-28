<?php
namespace  App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes for doctors
Route::middleware(['auth', 'isDoctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
    Route::post('/doctor/schedule', [DoctorController::class, 'updateSchedule']);
});

// Routes for patients
Route::middleware(['auth', 'isPatient'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard']);
    Route::post('/patient/book-appointment', [PatientController::class, 'bookAppointment']);
});
