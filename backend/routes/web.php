<?php
namespace  App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('doctor')->group(function () {
    Route::get('/login', [DoctorController::class, 'loginForm'])->name('login');
    Route::get('/register', [DoctorController::class, 'registerForm'])->name('register');
    Route::post('/register', [DoctorController::class, 'register']);
    Route::post('/login', [DoctorController::class, 'login'])->name('loginPost');

    Route::middleware(['auth:doctor', 'isDoctor'])->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'Dashboard'])->name('dashboard');
        Route::get('/manage-calender', [DoctorController::class, 'ManageCalender'])->name('ManageCalender');
        Route::post('/logout', [DoctorController::class, 'logout'])->name('logout');
        Route::post('/schedule', [DoctorController::class, 'updateSchedule']);
        Route::post('/addNewSlot', [DoctorController::class, 'addNewSlot'])->name('addNewSlot');
        Route::get('/AvailableForCreate', [DoctorController::class, 'AvailableForCreate'])->name('AvailableForCreate');
        Route::get('/upcomingAppointment', [DoctorController::class, 'UpcomingAppointment'])->name('UpcomingAppointment');
        Route::patch('/appointments/{id}/confirm', [AppointmentController::class, 'confirmAppointment'])->name('confirmAppointment');
        Route::patch('/appointments/{id}/cancel', [AppointmentController::class, 'cancelAppointment'])->name('cancelAppointment');
    });
});
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
