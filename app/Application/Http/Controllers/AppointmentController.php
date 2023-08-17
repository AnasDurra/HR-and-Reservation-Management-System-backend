<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\AddCaseNoteRequest;
use App\Application\Http\Resources\AppointmentResource;
use App\Application\Http\Resources\CaseNoteResource;
use App\Domain\Models\CD\Appointment;
use App\Domain\Models\CD\CaseNote;
use App\Domain\Services\AppointmentService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    private AppointmentService $AppointmentService;

    public function __construct(AppointmentService $AppointmentService)
    {
        $this->AppointmentService = $AppointmentService;
    }

    public function index(): JsonResponse
    {
        $appointments = $this->AppointmentService->getAppointmentList();
        return response()->json([
            'data' => AppointmentResource::collection($appointments) //Modify it as needed
        ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->getAppointmentById($id);
        return response()->json([
            'data' => new AppointmentResource($appointment) //Modify it as needed
        ], 200);
    }

    public function store(): JsonResponse
    {
        $appointment = $this->AppointmentService->createAppointment(request()->all());
        return response()->json([
            'data' => new AppointmentResource($appointment) //Modify it as needed
        ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->updateAppointment($id, request()->all());
        return response()->json([
            'data' => new AppointmentResource($appointment) //Modify it as needed
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->deleteAppointment($id);
        return response()->json([
            'data' => new AppointmentResource($appointment) //Modify it as needed
        ], 200);
    }

    public function attendanceModification($app_id, $status_id): AppointmentResource
    {
        $appointment = $this->AppointmentService->attendanceModification($app_id, $status_id);
        return new AppointmentResource($appointment);
    }

    public function appointmentPreview(AddCaseNoteRequest $request): CaseNoteResource
    {
        $validated = $request->validated();
        $case_note = $this->AppointmentService->appointmentPreview($validated);
        return new CaseNoteResource($case_note);
    }

}
