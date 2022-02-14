<?php

use Illuminate\Support\Facades\Route;

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
    Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('/register',[\App\Http\Controllers\Auth\LoginController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function (){
    Route::view('/home', 'common.home')->name('home');
    Route::get('/logout',[\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//    admin
    Route::view('/register-doctor', 'admin.register-doctor');
    Route::post('/register-doctor',[\App\Http\Controllers\Auth\LoginController::class, 'registerDoctor'])->name('register-doctor');

//    doctor
    Route::get('/profile', [\App\Http\Controllers\Auth\LoginController::class, 'showProfile'])->name('profile');
    Route::post('/edit-profile',[\App\Http\Controllers\Auth\LoginController::class, 'editDoctorProfile'])->name('edit-profile');
});










Route::prefix('/test')->group(function (){
//    Route::get('/', [\App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/show/{patient_record}', [\App\Http\Controllers\PatientRecordController::class, 'show']);
    Route::get('/pr/{patient_id}', [\App\Http\Controllers\PatientRecordController::class, 'index']);
});

Route::get('/main/patient', function () {
    return view('patient-main');
});


