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
use App\Http\Controllers\UserAppointmentController;
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
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function(Request $request) {
        return auth()->user();
    });

    //MASTER DATA (ADMIN ONLY)

    Route::group(['middleware' => ['adminonly']], function(){
        //Accounting Period
        Route::post('/accountingperiod', [AccountingPeriodController::class, 'store']);
        Route::post('/accountingperiod/{id}', [AccountingPeriodController::class, 'update']);
        Route::delete('/accountingperiod/{id}', [AccountingPeriodController::class, 'destroy']);
        Route::post('/periodstatus/{id}', [AccountingPeriodController::class, 'activateDeactivate']);

        //User
        Route::post('/account', [UserController::class, 'store']);
        Route::delete('/account/{id}', [UserController::class, 'destroy']);
        Route::post('/account/{id}', [UserController::class, 'update']);

        //BankAccount
        Route::post('/bankaccount', [BankAccountController::class, 'store']);
        Route::delete('/bankaccount/{id}', [BankAccountController::class, 'destroy']);
        Route::post('/bankaccount/{id}', [BankAccountController::class, 'update']);
        
        //ChartAccount
        Route::post('/chartaccount', [ChartAccountController::class, 'store']);
        Route::delete('/chartaccount/{id}', [ChartAccountController::class, 'destroy']);
        Route::post('/chartaccount/{id}', [ChartAccountController::class, 'update']);
        
        //Project
        Route::post('/project', [ProjectController::class, 'store']);
        Route::delete('/project/{id}', [ProjectController::class, 'destroy']);
        Route::post('/project/{id}', [ProjectController::class, 'update']);

        //Asset
        Route::resource('/asset', AssetController::class)->except('update', 'create', 'edit');
        Route::post('/asset/{id}', [JournalController::class, 'update']);
    });

    //-------------------------------------------------------------------------------------------------------

    //STAFF RESTRICTION

    Route::group(['middleware' => ['staffrestrict']], function(){

        //Journal
        Route::post('/verifjournal/{id}', [JournalController::class, 'validationStatus']);
        Route::post('/declinejournal/{id}', [JournalController::class, 'declineStatus']);
        Route::get('/journal/export/', [JournalController::class, 'export']);
        Route::post('/journal/import/', [JournalController::class, 'import']);

    });



    //-------------------------------------------------------------------------------------------------------
    
    //ALL USER

    //USER
    Route::post('/changepassword', [UserController::class, 'change_password']);

    //AUTH
    Route::get('/logout', [LoginController::class, 'logout']);

    //User Appointment
    Route::get('/userappointment/{id}', [UserAppointmentController::class, 'index']);

    //Appointment
    Route::resource('/appointment', AppointmentController::class)->except('update', 'create', 'edit');
    Route::get('/appointmentmail/{id}', [AppointmentController::class, 'mailJob']);
    Route::post('/appointment/{id}', [AppointmentController::class, 'update']);   

    //Journal
    Route::resource('/journal', JournalController::class)->except('update', 'create', 'edit');
    Route::post('/journal/{id}', [JournalController::class, 'update']);
    Route::post('/validjournal/{id}', [JournalController::class, 'draftToProcess']);

    //AdjustingHistory
    Route::resource('/adjustinghistory', AdjustingHistoryController::class)->except('index', 'update', 'create', 'edit');
    Route::get('/journalhistories/{id}', [AdjustingHistoryController::class, 'index']);
    Route::post('/adjustinghistory/{id}', [AdjustingHistoryController::class, 'update']);

    //-------------------------------------------------------------------------------------------------------

});

//GET MASTER DATA
Route::resource('/accountingperiod', AccountingPeriodController::class)->except('destroy', 'store', 'update', 'create', 'edit');
Route::resource('/account', UserController::class)->except('destroy', 'store', 'update', 'create', 'edit');
Route::resource('/bankaccount', BankAccountController::class)->except('destroy', 'store', 'update', 'create', 'edit');
Route::resource('/chartaccount', ChartAccountController::class)->except('destroy', 'store', 'update', 'create', 'edit');
Route::resource('/project', ProjectController::class)->except('destroy', 'store', 'update', 'create', 'edit');

//AUTH
Route::post('/login', [LoginController::class, 'index']);
Route::get('/token/{id}', [LoginController::class, 'token']);

