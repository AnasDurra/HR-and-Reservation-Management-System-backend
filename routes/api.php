<?php

use App\Application\Http\Controllers\JobApplicationController;
use App\Application\Http\Controllers\DepartmentController;
use App\Application\Http\Controllers\JobVacancyController;
use App\Application\Http\Controllers\JobTitleController;
use App\Application\Http\Controllers\PermissionController;
use App\Application\Http\Controllers\EmployeeController;
use App\Application\Http\Controllers\ScheduleController;
use App\Application\Http\Controllers\BiometricDeviceController;
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

// Register the routes for the DepartmentController
Route::apiResource('departments', DepartmentController::class);

// Register the routes for the JobVacancyController
Route::apiResource('job-vacancies', JobVacancyController::class);

// Register the routes for the JobTitleController
Route::apiResource('job-titles', JobTitleController::class);

// Register the routes for the PermissionController
Route::get('permissions', [PermissionController::class,'index']);
Route::get('permissions/{id}', [PermissionController::class,'show']);

// Register the routes for the EmployeeController
Route::post('employees/edit-permissions/{id}', [EmployeeController::class,'editPermissions']);

// Register the routes for the ScheduleController
Route::apiResource('schedules', ScheduleController::class);

// Register the routes for the BiometricDeviceController
Route::apiResource('finger_device', BiometricDeviceController::class);


