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
use PharIo\Version\Exception;

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

    public function bookAnAppointmentByEmployee(int $appointment_id, int $customer_id): AppointmentResource
    {
        $appointment = $this->TimeSheetService->bookAnAppointmentByEmployee($appointment_id, $customer_id);

        return new AppointmentResource($appointment);
    }

    public function getConsultantSchedule(): AnonymousResourceCollection
    {
        $schedule = $this->TimeSheetService->getConsultantSchedule();
        return AppointmentResource::collection($schedule);

    }

    public function cancelAppointmentByConsultant($id): AppointmentResource
    {
        $appointment = $this->TimeSheetService->cancelAppointmentByConsultant($id);
        return new AppointmentResource($appointment);
    }

    public function getCanceledAppointment(): AnonymousResourceCollection
    {
        $canceled_appointment = $this->TimeSheetService->getCanceledAppointment();
        return AppointmentResource::collection($canceled_appointment);
    }

}
