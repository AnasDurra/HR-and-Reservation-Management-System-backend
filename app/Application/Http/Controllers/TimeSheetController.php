<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\AddWorkDayRequest;
use App\Application\Http\Requests\StoreTimeSheetRequest;
use App\Application\Http\Resources\AppointmentResource;
use App\Application\Http\Resources\TimeSheetResource;
use App\Domain\Models\CD\Appointment;
use App\Domain\Services\TimeSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TimeSheetController extends Controller
{
    private TimeSheetService $TimeSheetService;

    public function __construct(TimeSheetService $TimeSheetService)
    {
        $this->TimeSheetService = $TimeSheetService;
    }

    public function index(): AnonymousResourceCollection
    {
        $timeSheets = $this->TimeSheetService->getTimeSheetList();
        return TimeSheetResource::collection($timeSheets);
    }


    public function store(StoreTimeSheetRequest $request): JsonResponse
    {
        // validate request data
        $validated = $request->validated();

        // create job application
        $this->TimeSheetService->createTimeSheet($validated);

        return response()->json([
            'message' => 'Time Sheet Created Successfully'
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $this->TimeSheetService->deleteTimeSheet($id);
        return response()->json([
            'message' => 'Time Sheet Deleted Successfully'
        ]);
    }

    public function addWorkDay(AddWorkDayRequest $request): JsonResponse
    {
        // validate request data
        $validated = $request->validated();
        $this->TimeSheetService->addWorkDay($validated);

        return response()->json([
            'message' => 'Work Day Added Successfully'
        ]);
    }

    public function bookAnAppointmentByEmployee(int $appointment_id, int $customer_id): JsonResponse
    {
        $this->TimeSheetService->bookAnAppointmentByEmployee($appointment_id, $customer_id);

        return response()->json([
            'message' => 'Appointment booked Successfully for Customer with id : ' . $customer_id
        ]);
    }

    public function getConsultantSchedule(): AnonymousResourceCollection
    {
        $schedule = $this->TimeSheetService->getConsultantSchedule();
        return TimeSheetResource::collection($schedule);

    }

    public function cancelAppointmentByConsultant($id): JsonResponse
    {
        $this->TimeSheetService->cancelAppointmentByConsultant($id);
        return response()->json([
            'message' => 'AppointmentResource Canceled Successfully'
        ]);
    }

    public function getCanceledAppointment(): AnonymousResourceCollection
    {
        $canceled_appointment = $this->TimeSheetService->getCanceledAppointment();
        return AppointmentResource::collection($canceled_appointment);
    }

    /**
     * cancel reservation by customer
     */
    public function cancelReservationByCustomer(Appointment $appointment): JsonResponse
    {

        // make sure the appointment is in the future
        if ($appointment->is_future === false) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه مضى',
            ], 422);
        }

        // make sure the appointment is reserved
        if ($appointment->is_reserved === false) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه لم يتم حجزه',
            ], 422);
        }

        $appointment = $this->TimeSheetService->cancelReservationByCustomer($appointment);
        return response()->json([
            'message' => 'تم إلغاء الموعد بنجاح',
            'data' => new AppointmentResource($appointment),
        ]);
    }

    /**
     * cancel reservation by employee
     */
    public function cancelReservationByEmployee(Appointment $appointment): JsonResponse
    {
        // make sure the appointment is in the future
        if (!$appointment->is_future) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه مضى',
            ], 422);
        }

        $appointment = $this->TimeSheetService->cancelReservationByEmployee($appointment->id);
        return response()->json([
            'message' => 'تم إلغاء الموعد بنجاح',
            'data' => new AppointmentResource($appointment),
        ]);
    }

    /**
     * cancel reservation by consultant
     */
    public function cancelReservationByConsultant(Appointment $appointment): JsonResponse
    {
        // make sure the appointment is in the future
        if ($appointment->is_future === false) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه مضى',
            ], 422);
        }

        $appointment = $this->TimeSheetService->cancelReservationByConsultant($appointment->id);
        return response()->json([
            'message' => 'تم إلغاء الموعد بنجاح',
            'data' => new AppointmentResource($appointment),
        ]);
    }

    /**
     * cancel reservation (make it available again)
     */
    public function cancelReservation(Appointment $appointment): JsonResponse
    {
        // make sure the user is an employee
        if (!auth()->user()->isEmployee()) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنك لست موظف',
            ], 403);
        }

        // make sure the appointment is in the future
        if (!$appointment->is_future) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه مضى',
            ], 422);
        }

        // make sure the appointment is already reserved
        if (!$appointment->is_reserved) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الموعد لأنه غير محجوز',
            ], 422);
        }

        // cancel the appointment
        $appointment = $this->TimeSheetService->cancelReservation($appointment);
        return response()->json([
            'message' => 'تم إلغاء الموعد بنجاح',
            'data' => new AppointmentResource($appointment),
        ]);
    }
}
