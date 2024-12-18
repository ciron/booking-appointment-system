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
Route::middleware('guest')->group(function () {

    // Routes for patients

    Route::prefix('patient')->group(function () {
        Route::post('/register', [PatientController::class, 'register']);
        Route::post('/login', [PatientController::class, 'login']);

        Route::middleware(['isPatient'])->group(function () {

            Route::get('/doctor-list', [DoctorController::class, 'DoctorList']);
            Route::get('/doctor-slot-list/{id}', [DoctorController::class, 'DoctorAvailableSlot']);
            Route::post('/appointments/book', [AppointmentController::class, 'bookAppointment']);
            Route::get('/appointments', [AppointmentController::class, 'Appointments']);
            Route::post('/logout', [PatientController::class, 'logout']);
        });
    });
});
