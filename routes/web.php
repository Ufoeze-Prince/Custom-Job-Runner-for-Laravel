<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobDashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobHistoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/run-job', function () {
    runBackgroundJob(\App\ExampleJob::class, 'sendMessage', ['Hello, World!']);
});




// Route::get('/dashboard', [JobDashboardController::class, 'index'])->name('dashboard.index');
// Route::delete('/dashboard/cancel/{jobId}', [JobDashboardController::class, 'cancelJob'])->name('dashboard.cancel');



Route::get('/job-dashboard', [JobHistoryController::class, 'index'])->name('job-dashboard.index');
Route::post('/job-dashboard/cancel/{id}', [JobHistoryController::class, 'cancelJob'])->name('job-dashboard.cancel');
Route::post('/job-dashboard/retry/{id}', [JobHistoryController::class, 'retryJob'])->name('job-dashboard.retry');



Route::get('/fetch-and-run-jobs', [JobController::class, 'fetchAndRunJobs'])->name('fetch-and-run-jobs');


Route::get('/dispatch-job', [JobController::class, 'dispatchJob']);


