<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReportController;
use Inertia\Inertia;

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
    return Inertia::render("Auth/Login",);
});


Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('doctors', DoctorController::class);
});

Route::group(['middleware' => 'App\Http\Middleware\AuthMiddleware'], function () {
    Route::resource('patients', PatientController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('reports', ReportController::class);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
