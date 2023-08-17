<?php

use App\Application\Http\Controllers\AppointmentController;
use App\Application\Http\Controllers\AuthenticationController;
use App\Application\Http\Controllers\CustomerController;
use App\Application\Http\Controllers\JobApplicationController;
use App\Application\Http\Controllers\DepartmentController;
use App\Application\Http\Controllers\JobVacancyController;
use App\Application\Http\Controllers\JobTitleController;
use App\Application\Http\Controllers\LogController;
use App\Application\Http\Controllers\PermissionController;
use App\Application\Http\Controllers\EmployeeController;
use App\Application\Http\Controllers\ReportController;
use App\Application\Http\Controllers\ScheduleController;
use App\Application\Http\Controllers\BiometricDeviceController;
use App\Application\Http\Controllers\AttendanceController;
use App\Application\Http\Controllers\LeaveController;
use App\Application\Http\Controllers\TimeSheetController;
use App\Application\Http\Controllers\VacationRequestController;
use App\Application\Http\Controllers\WorkingDayController;
use App\Application\Http\Controllers\HolidayController;
use App\Application\Http\Controllers\EmployeeVacationController;
use App\Application\Http\Controllers\ShiftRequestController;
use App\Application\Http\Controllers\AbsenceController;
use App\Application\Http\Controllers\EducationLevelController;
use App\Application\Http\Controllers\EventController;
use App\Application\Http\Controllers\UnRegisteredAccountController;


use App\Application\Http\Controllers\ConsultantController;
use App\Application\Http\Controllers\ClinicController;
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

// login route
Route::post('login', [AuthenticationController::class, 'userLogin']);

Route::middleware('auth:sanctum')->group(function () {
    // login route
    Route::post('/logout', [AuthenticationController::class, 'userLogout']);

    // get employee by token route
    Route::get('/employee', [AuthenticationController::class, 'getUserActivePermissionsByToken']);

    // Register the routes for the JobApplicationController
    Route::post("job-applications/update/{id}", [JobApplicationController::class, 'update']);
    Route::post("job-applications/destroy", [JobApplicationController::class, 'destroy']);
    Route::apiResource("job-applications", JobApplicationController::class)->except(['update', 'destroy']);
    Route::post('/job-applications/accept/{id}', [JobApplicationController::class, 'acceptJobApplication']);
    Route::post('/job-applications/reject/{id}', [JobApplicationController::class, 'rejectJobApplication']);

    // Register the routes for Employee Management
    Route::prefix('employees')->group(function () {

        // get all employees
        Route::get('/list', [EmployeeController::class, 'indexList']);

        // get employee log
        Route::get('/log/{id}', [EmployeeController::class, 'indexLog']);

        // get employee absence history
        Route::get('/absence/{id}', [EmployeeController::class, 'indexAbsence']);

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
    Route::apiResource('shift-request', ShiftRequestController::class);
    Route::post('/shift-request/update/{id}', [ShiftRequestController::class, 'update']);
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
    Route::get('log/all-log', [LogController::class, 'getLog']);

    // Register the routes for the AbsenceController
    Route::apiResource('absences', AbsenceController::class);
    Route::get('employee-absences/{emp_id}', [AbsenceController::class, 'showEmployeeAbsences']);

// TEMP  ROUT FOR PDF
    Route::get('pdf', [ReportController::class, 'create']);

});

// Register the routes for the CustomerController
Route::apiResource('customer', CustomerController::class);
//Route::post('customer/update/before/{id}', [CustomerController::class, 'updateBeforeVerified']);
//Route::post('customer/update/after/{id}', [CustomerController::class, 'updateAfterVerified']);
Route::post('customer/user-sing-up', [CustomerController::class, 'userSingUp']);
Route::post('customer/login', [CustomerController::class, 'userLogin']);
Route::post('customer/logout', [CustomerController::class, 'userLogout']);

Route::post('customer/add-by-emp', [CustomerController::class, 'addCustomerByEmployee']);
Route::post('customer/{id}', [CustomerController::class, 'update']);
Route::get('missed-Appointments-By-Customers', [CustomerController::class, 'customersMissedAppointments']);
Route::put('customer/toggle-status/{customer_id}', [CustomerController::class, 'customerToggleStatus']);

// Register the routes for the customerDetection
Route::post('customer-detection', [CustomerController::class, 'customerDetection']);

// Register the routes for the customerVerification
Route::post('customer-verification', [CustomerController::class, 'customerVerification']);

// Register the routes for the customerStatistics
Route::get('customer/statistics/{id}', [CustomerController::class,'getStatistics']);


// Register the router for EducationLevelController
Route::apiResource('education_levels', EducationLevelController::class);

// Register the routes for the ConsultantController
Route::apiResource('consultant', ConsultantController::class);
Route::get('consultant/statistics/{id}', [ConsultantController::class,'getStatistics']);
Route::get('consultant/monthly-statistics/{id}', [ConsultantController::class,'getMonthlyStatistics']);

// Register the routes for the ClinicController
Route::apiResource('clinic', ClinicController::class);

// Register the routes for the EventController
Route::apiResource('events', EventController::class)->except(['update']);
Route::post('events/{event}', [EventController::class, 'update']);

// Register the routes for the UnRegisteredAccountController
Route::apiResource('book-un-registered-account', UnRegisteredAccountController::class);

Route::apiResource('time-sheet', TimeSheetController::class);
Route::post('add-work-day', [TimeSheetController::class, 'addWorkDay']);
Route::put('book-by-employee/{app_id}/{customer_id}', [TimeSheetController::class, 'bookAnAppointmentByEmployee']);
Route::get('consultant-schedule', [TimeSheetController::class, 'getConsultantSchedule']);
Route::put('cancel-appointment/{id}', [TimeSheetController::class, 'cancelAppointmentByConsultant']);
Route::get('canceled-appointment', [TimeSheetController::class, 'getCanceledAppointment']);

//Appointment
Route::put('attendance-modification/{app_id}/{status_id}', [AppointmentController::class, 'attendanceModification']);
Route::post('add-case-note', [AppointmentController::class, 'appointmentPreview']);

// cancel reservation(deny future reservation)
// 1. by customer
Route::post('cancel-reservation-by-customer/{appointment}', [TimeSheetController::class, 'cancelReservationByCustomer']);

// 2. by employee
Route::post('cancel-appointment-by-employee/{appointment}', [TimeSheetController::class, 'cancelReservationByEmployee']);

// 3. by consultant
Route::post('cancel-reservation-by-consultant/{appointment}', [TimeSheetController::class, 'cancelReservationByConsultant']);

// cancel reservation(to be reservable again)
Route::post('cancel-reservation-by-employee/{appointment}', [TimeSheetController::class, 'cancelReservation']);


// get all time slots (appointments) for a specific consultant in a specific date
Route::get('consultant-time-slots/{consultant_id}/{date}', [TimeSheetController::class, 'getConsultantTimeSlots']);
