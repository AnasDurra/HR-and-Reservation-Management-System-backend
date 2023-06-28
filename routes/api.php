<?php

use App\Application\Http\Controllers\JobApplicationController;
use App\Application\Http\Controllers\DepartmentController;
use App\Application\Http\Controllers\JobVacancyController;
use App\Application\Http\Controllers\JobTitleController;
use App\Application\Http\Controllers\LogController;
use App\Application\Http\Controllers\PermissionController;
use App\Application\Http\Controllers\EmployeeController;
use App\Application\Http\Controllers\ScheduleController;
use App\Application\Http\Controllers\BiometricDeviceController;
use App\Application\Http\Controllers\AttendanceController;
use App\Application\Http\Controllers\LeaveController;
use App\Application\Http\Controllers\WorkingDayController;
use App\Application\Http\Controllers\HolidayController;
use App\Application\Http\Controllers\EmployeeVacationController;
use App\Application\Http\Controllers\ShiftRequestController;
use App\Application\Http\Controllers\VacationRequestController;
use App\Application\Http\Controllers\AbsenceController;
use App\Application\Http\Controllers\PDFgenerator;
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
Route::post("job-applications/update/{id}", [JobApplicationController::class, 'update']);
Route::post("job-applications/destroy", [JobApplicationController::class, 'destroy']);
Route::apiResource("job-applications", JobApplicationController::class)->except(['update', 'destroy']);
Route::post('/job-applications/accept/{id}', [JobApplicationController::class, 'acceptJobApplication']);
Route::post('/job-applications/reject/{id}', [JobApplicationController::class, 'rejectJobApplication']);

// Register the routes for the EmployeeController
Route::prefix('employees')->group(function () {
//    Route::post('/{id}', [EmployeeController::class, 'update']);
    Route::get('/list', [EmployeeController::class, 'indexList']);
    Route::get('/job-title-history/{id}', [EmployeeController::class, 'indexJobTitles']);
    Route::get('/department-history/{id}', [EmployeeController::class, 'indexDepartments']);
    Route::post('/edit-credentials/{id}', [EmployeeController::class, 'editCredentials']);
    Route::post('/edit-department/{id}', [EmployeeController::class, 'editDepartment']);
    Route::post('/edit-employment-status/{id}', [EmployeeController::class, 'editEmploymentStatus']);
    Route::post('/edit-schedule/{id}', [EmployeeController::class, 'editSchedule']);
    Route::post('/edit-permissions/{id}', [EmployeeController::class, 'editPermissions']);
});
Route::apiResource('employees', EmployeeController::class);

// Register the routes for the DepartmentController
Route::apiResource('departments', DepartmentController::class);

// Register the routes for the JobVacancyController
Route::apiResource('job-vacancies', JobVacancyController::class);

//Register the routes for the ShiftRequestController
Route::apiResource('shift-request', ShiftRequestController::class)->except(['update']);
Route::post('/shift-request/{id}', [ShiftRequestController::class, 'update']);
Route::post('/shift-request/accept/{id}', [ShiftRequestController::class, 'acceptShiftRequest']);
Route::post('/shift-request/reject/{id}', [ShiftRequestController::class, 'rejectShiftRequest']);

//Register the routes for the VacationRequestController
Route::apiResource('vacation-request', VacationRequestController::class);
Route::post('/vacation-request/update/{id}', [VacationRequestController::class, 'update']);
Route::post('/vacation-request/accept/{id}', [VacationRequestController::class, 'acceptVacationRequest']);
Route::post('/vacation-request/reject/{id}', [VacationRequestController::class, 'rejectVacationRequest']);
Route::apiResource('vacation-request', VacationRequestController::class)->except(['update']);

// Register the routes for the JobTitleController
Route::apiResource('job-titles', JobTitleController::class);

// Register the routes for the PermissionController
Route::get('permissions', [PermissionController::class, 'index']);
Route::get('permissions/{id}', [PermissionController::class, 'show']);

//// Register the routes for the EmployeeController
//Route::post('employees/edit-permissions/{id}', [EmployeeController::class, 'editPermissions']);

// Register the routes for the ScheduleController
Route::apiResource('schedules', ScheduleController::class);

// Register the routes for the BiometricDeviceController
Route::apiResource('finger_device', BiometricDeviceController::class);

// Register the routes for the AttendanceController
Route::apiResource('attendance', AttendanceController::class);
Route::get('employee/attendances/{emp_id}', [AttendanceController::class, 'showEmployeeAttendance']);

// Register the routes for the LeaveController
Route::apiResource('leave', LeaveController::class);

// Register the routes for the WorkingDayController
Route::get('working_days', [WorkingDayController::class, 'index']);
Route::put('working_days/{id}', [WorkingDayController::class, 'update']);

// Register the routes for the HolidayController
Route::apiResource('holidays', HolidayController::class);

// Register the routes for the EmployeeVacationController
Route::apiResource('employees-vacations', EmployeeVacationController::class);
Route::get('employee-vacations/{emp_id}', [EmployeeVacationController::class, 'showEmployeeVacations']);

//Register the routes for the LogController
Route::get('log/all-action', [LogController::class, 'getAllAction']);
Route::get('log/all-affected-user', [LogController::class, 'getAllAffectedUser']);
Route::get('log/all-user', [LogController::class, 'getAllUser']);

// Register the routes for the AbsenceController
Route::apiResource('absences', AbsenceController::class);
Route::get('employee-absences/{emp_id}', [AbsenceController::class, 'showEmployeeAbsences']);

// TEMP  ROUT FOR PDF
Route::post('pdf', [PDFgenerator::class,'createPDF']);


