<?php

use App\Http\Controllers\AccountingPeriodController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ChartAccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Accounting Period
Route::resource('/accountingperiod', AccountingPeriodController::class)->except('create', 'edit');
//User
Route::resource('/user', UserController::class)->except('create', 'edit');
//Appointment
Route::resource('/appointment', AppointmentController::class)->except('create', 'edit');
//BankAccount
Route::resource('/bankaccount', BankAccountController::class)->except('create', 'edit');
//ChartAccount
Route::resource('/chartaccount', ChartAccountController::class)->except('create', 'edit');
//Project
Route::resource('/project', ProjectController::class)->except('create', 'edit');
//Journal
Route::resource('/journal', JournalController::class)->except('create', 'edit');
