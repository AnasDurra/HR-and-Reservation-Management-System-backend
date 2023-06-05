<?php

use App\Application\Http\Controllers\JobApplicationController;
use App\Application\Http\Controllers\DepartmentController;
use App\Application\Http\Controllers\JobVacancyController;
use App\Application\Http\Controllers\ShiftRequestController;
use App\Application\Http\Controllers\VacationRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register the routes for the JobApplicationController
Route::apiResource("job-applications", JobApplicationController::class);
Route::post('/job-applications/accept/{id}', [JobApplicationController::class, 'acceptJobApplication']);
Route::post('/job-applications/reject/{id}', [JobApplicationController::class, 'rejectJobApplication']);

// Register the routes for the DepartmentController
Route::apiResource('departments', DepartmentController::class);

// Register the routes for the DepartmentController
Route::apiResource('job-vacancies', JobVacancyController::class);

//Register the routes for the ShiftRequestController
Route::apiResource('shift-request' , ShiftRequestController::class);
Route::post('/shift-request/update/{id}', [ShiftRequestController::class, 'update']);
Route::post('/shift-request/accept/{id}', [ShiftRequestController::class, 'acceptShiftRequest']);
Route::post('/shift-request/reject/{id}', [ShiftRequestController::class, 'rejectShiftRequest']);

//Register the routes for the VacationRequestController
Route::apiResource('vacation-request' , VacationRequestController::class);
Route::post('/vacation-request/update/{id}', [VacationRequestController::class, 'update']);
Route::post('/vacation-request/accept/{id}', [VacationRequestController::class, 'acceptVacationRequest']);
Route::post('/vacation-request/reject/{id}', [VacationRequestController::class, 'rejectVacationRequest']);
