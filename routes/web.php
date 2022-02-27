<?php

use App\Http\Controllers\AdminDoctor\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
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

Route::middleware('guest')->group(function (){
    Route::view('/register', 'auth.register')->name('register-form');
    Route::view('/login', 'auth.login')->name('login-form');
    Route::post('/login',[LoginController::class, 'login'])->name('login');
    Route::post('/register',[LoginController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function (){
    Route::view('/home', 'common.home')->name('home');
    Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

//  doctor and admin
    Route::get('/patients', [PatientController::class,'index'])->name('patient.index');
    Route::delete('/patients/{patient}', [PatientController::class,'destroy'])->name('patient.delete');
    Route::get('/patients/{patient}', [PatientController::class,'show'])->name('patient.show');

    Route::get('/patients-record/create/{patient}',[PatientRecordController::class,'create'])->name('patient-record.create');
    Route::post('/patients-record',[PatientRecordController::class,'store'])->name('patient-record.store');
    Route::get('/patients-record/{patient_record}/edit',[PatientRecordController::class,'edit'])->name('patient-record.edit');
    Route::put('/patients-record/{patient_record}',[PatientRecordController::class,'update'])->name('patient-record.update');
    Route::delete('/patients-record/{patient_record}',[PatientRecordController::class,'destroy'])->name('patient-record.destroy');

//    admin
    Route::middleware('can:admin-access')->group(function (){
        Route::view('/register-doctor', 'admin.register-doctor');
        Route::post('/register-doctor',[LoginController::class, 'registerDoctor'])->name('register-doctor');
        Route::view('/doctors','admin-doctors')->name('doctor.index');
    });


//    doctor
    Route::middleware('can:doctor-access')->group(function (){
        Route::get('/profile', [LoginController::class, 'showProfile'])->name('profile');
        Route::put('/edit-profile',[LoginController::class, 'editDoctorProfile'])->name('doctor.edit-profile');
    });
});






Route::prefix('/test')->group(function (){
//    Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/show/{patient_record}', [PatientRecordController::class, 'show']);
    Route::get('/pr/{patient_id}', [PatientRecordController::class, 'index']);
});

Route::get('/patient/main', function () {
    return view('patient-main');
});


Route::get('/admin/appointment', [AppointmentController::class,'showAll']);


Route::get('/doctor/appointment', function () {
    return view('doctor/doctor-appointment');
});



Route::get('/admin/doctors', function () {
    return view('admin-doctors');
});

