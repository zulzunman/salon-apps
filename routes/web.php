<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ServiceController;
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

Route::get('/', [LoginController::class, 'homePage'])->name('home-page');
Route::get('/login', [LoginController::class, 'formLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-staff');

// registration
Route::get('/registration/add-data', [RegistrationController::class, 'formRegist'])->name('register.form-add');
Route::post('/registration/add', [RegistrationController::class, 'addData'])->name('register.add-data');

// Route untuk dashboard berbeda berdasarkan role
Route::middleware(['auth'])->group(function () {
    // after authentication
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // registration
    Route::get('/registration', [RegistrationController::class, 'getData'])->name('register.get-data');
    Route::post('/registration/call/{id}', [RegistrationController::class, 'callCustomer'])->name('register.calling');
    Route::post('/registration/serving/{id}', [RegistrationController::class, 'servingCustomer'])->name('register.serving');
    Route::post('/registration/complete/{id}', [RegistrationController::class, 'completeCustomer'])->name('register.complete');

    // service
    Route::get('/service', [ServiceController::class, 'getData'])->name('service.get-data');
    Route::get('/service/add', [ServiceController::class, 'formAdd'])->name('service.form-add');
    Route::post('/service/add/add-data', [ServiceController::class, 'addData'])->name('service.add-data');
    Route::get('/service/edit/{id}', [ServiceController::class, 'formEdit'])->name('service.form-edit');
    Route::post('/service/edit/{id}/edit-data', [ServiceController::class, 'editData'])->name('service.edit-data');
    Route::post('/service/delete/{id}', [ServiceController::class, 'deleteData'])->name('service.delete-data');
});