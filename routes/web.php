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
    return view('welcome');
});

Route::get('/patient/main', function () {
    return view('patient-main');
});

Route::get('/admin/appointment', function () {
    return view('admin-appointment');
});

Route::get('/doctor/appointment', function () {
    return view('doctor-appointment');
});

