<?php

use App\Http\Controllers\AdminDoctor\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Models\Doctor;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(\route('home'));
});

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register-form');
    Route::view('/login', 'auth.login')->name('login-form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::view('/home', 'common.home')->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [LoginController::class, 'showProfile'])->name('common.show-profile');
    Route::put('/edit-profile', [LoginController::class, 'editProfile'])->name('common.edit-profile');
    Route::get('/change-password', [LoginController::class, 'showEditPassword'])->name('common.show-password');
    Route::put('/change-password', [LoginController::class, 'editPassword'])->name('common.edit-password');

    //    patient
    Route::middleware('can:patient-access')->group(function () {
        Route::get('/patients-profile', [PatientController::class, 'showOwnProfile'])->name('patient-profile.show');
        Route::get('/patient/home', [PatientController::class, 'home'])->name('patient.home');
        Route::get('/appointment/create/{doctor}', [AppointmentController::class, 'patientCreate'])->name('appointment.create');
        Route::post('/appointment/create', [AppointmentController::class, 'patientStore'])->name('appointment.store');
        Route::get('/appointment/{appointment}/edit', [AppointmentController::class, 'patientEdit'])->name('appointment.edit');
        Route::post('/patient/appointment/{appointment}', [AppointmentController::class, 'editAppointment'])->name('appointment.update');
        Route::delete('/patient/appointment/{appointment}/delete', [AppointmentController::class, 'destroy'])->name('appointment.delete');
    });
    Route::post('/schedule/view-timeslot/{schedule}', [\App\Http\Controllers\ScheduleController::class, 'viewTimeslot'])->name('schedule.view-timeslot');


    //  doctor and admin
    Route::middleware('can:doctor-or-admin')->group(function () {
        Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patient.delete');
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patient.show');

        Route::get('/patients-record/create/{patient}', [PatientRecordController::class, 'create'])->name('patient-record.create');
        Route::post('/patients-record', [PatientRecordController::class, 'store'])->name('patient-record.store');
        Route::get('/patients-record/{patient_record}/edit', [PatientRecordController::class, 'edit'])->name('patient-record.edit');
        Route::put('/patients-record/{patient_record}', [PatientRecordController::class, 'update'])->name('patient-record.update');
        Route::delete('/patients-record/{patient_record}', [PatientRecordController::class, 'destroy'])->name('patient-record.destroy');

        Route::get('/mark-appointment-done/{appointment}', [AppointmentController::class, 'markAsDone'])->name('appointment.mark-done')->can('mark-done,appointment');
    });

    //    admin
    Route::middleware('can:admin-access')->prefix('admin')->group(function () {
        Route::view('/register-doctor', 'admin.register-doctor');

        Route::get('/appointment', [AppointmentController::class, 'showAdmin'])->name('admin-appointment');


        Route::get('/mark-appointment-approved/{appointment}', [AppointmentController::class, 'markAsApproved'])->name('appointment.mark-approved');
        Route::delete('/appointment/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.delete');
        Route::post('/update-appointment/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'editAppointment'])->name('appointment.update');

        Route::post('/register-doctor', [LoginController::class, 'registerDoctor'])->name('register-doctor');

        // doctor list
        Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctor.index');
        Route::get('/doctors/{doctor}/edit', [AdminDoctorController::class, 'edit'])->name('doctor.edit');
        Route::put('/doctors/{doctor}/edit', [AdminDoctorController::class, 'update']);
        Route::delete('/doctors/{doctor}', [AdminDoctorController::class, 'delete']);


        Route::get('/schedules/create', [\App\Http\Controllers\ScheduleController::class, 'showCreateForm'])->name('schedule.create');
        Route::post('/schedules', [\App\Http\Controllers\ScheduleController::class, 'store'])->name('schedule.store');
    });


    //    doctor
    Route::middleware('can:doctor-access')->prefix('doctor')->group(function () {
        Route::get('/appointment', [AppointmentController::class, 'showDoctor'])->name('doctor-appointment');
        Route::get('/mark-appointment-completed/{appointment}', [AppointmentController::class, 'markAsCompleted'])->name('appointment.mark-completed');
    });
});






Route::prefix('/test')->group(function () {
    //    Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/show/{patient_record}', [PatientRecordController::class, 'show']);
    Route::get('/pr/{patient_id}', [PatientRecordController::class, 'index']);
});


Route::get('/patient/create-appointment', function () {
    return view('patient.create-appointment');
});