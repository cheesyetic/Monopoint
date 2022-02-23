<?php

use App\Http\Controllers\AccountingPeriodController;
use App\Http\Controllers\AdjustingHistoryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ChartAccountController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\LoginController;
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

//AUTH
Route::post('/login', [LoginController::class, 'index']);
Route::get('/logout', [LoginController::class, 'logout']);

//Accounting Period
Route::resource('/accountingperiod', AccountingPeriodController::class)->except('update', 'create', 'edit');
Route::post('/accountingperiod/{id}', [AccountingPeriodController::class, 'update']);
Route::post('/periodstatus/{id}', [AccountingPeriodController::class, 'activateDeactivate']);
//User
Route::resource('/account', UserController::class)->except('update', 'create', 'edit');
Route::post('/account/{id}', [UserController::class, 'update']);
//Appointment
Route::resource('/appointment', AppointmentController::class)->except('update', 'create', 'edit');
Route::post('/appointment/{id}', [AppointmentController::class, 'update']);
//BankAccount
Route::resource('/bankaccount', BankAccountController::class)->except('update', 'create', 'edit');
Route::post('/bankaccount/{id}', [BankAccountController::class, 'update']);
//ChartAccount
Route::resource('/chartaccount', ChartAccountController::class)->except('update', 'create', 'edit');
Route::post('/chartaccount/{id}', [ChartAccountController::class, 'update']);
//Project
Route::resource('/project', ProjectController::class)->except('update', 'create', 'edit');
Route::post('/project/{id}', [ProjectController::class, 'update']);
//Journal
Route::get('/journal/export/', [JournalController::class, 'export']);
Route::post('/verifjournal/{id}', [JournalController::class, 'validationStatus']);
Route::post('/validjournal/{id}', [JournalController::class, 'validationImage']);
Route::resource('/journal', JournalController::class)->except('update', 'create', 'edit');
Route::post('/journal/{id}', [JournalController::class, 'update']);
Route::get('/sendemail', [JournalController::class, 'sendEmail']);
//Asset
Route::resource('/asset', AssetController::class)->except('update', 'create', 'edit');
Route::post('/asset/{id}', [JournalController::class, 'update']);
//AdjustingHistory
Route::resource('/adjustinghistory', AdjustingHistoryController::class)->except('update', 'create', 'edit');
Route::post('/adjustinghistory/{id}', [AdjustingHistoryController::class, 'update']);

