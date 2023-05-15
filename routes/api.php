<?php

use App\Application\Http\Controllers\JobApplicationController;
use App\Application\Http\Controllers\DepartmentController;
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
