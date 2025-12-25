<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeadPaymentController;
use App\Http\Controllers\PaymentReportController;
use App\Http\Controllers\DmcLeadController;
use App\Http\Controllers\DmcCommentController;
use App\Http\Controllers\AdminDmcLeadController;

Route::get('/health-check', function() {
    return 'Laravel is working!';
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DMC ONLY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:dmc'])->group(function () {

    Route::get('/dmc/leads', [DmcLeadController::class, 'index'])
        ->name('dmc.leads');

    Route::get('/dmc/leads/{lead}', [DmcLeadController::class, 'show'])
        ->name('dmc.leads.show');

    // Route::post('/leads/{lead}/dmc-comment', [DmcCommentController::class, 'store'])
    //     ->name('dmc.comment.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN + AGENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,agent'])->group(function () {

    /* DASHBOARD */
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* LEADS */
    Route::resource('leads', LeadController::class);

    Route::post('/leads/{lead}/call-logs', [CallLogController::class, 'store'])
        ->name('calllogs.store');

    /* USERS */
    Route::resource('users', UserController::class)
        ->except(['show', 'destroy']);

    /* REPORTS */
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/payments', [PaymentReportController::class, 'index'])
        ->name('reports.payments');

    /* PAYMENTS */
    Route::post('/leads/{lead}/payments', [LeadPaymentController::class, 'store'])
        ->name('payments.store');

    /* ADMIN → DMC LEADS */
    Route::get('/admin/dmc-leads', [AdminDmcLeadController::class, 'index'])
        ->name('admin.dmc.leads');

        // Route::post('/leads/{lead}/dmc-comment', [DmcCommentController::class, 'store'])
        //     ->name('dmc.comment.store');
});

Route::middleware('auth')->post('/leads/{lead}/dmc-comment',[DmcCommentController::class, 'store'])->name('dmc.comment.store');