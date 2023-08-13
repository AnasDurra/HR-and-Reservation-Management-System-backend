<?php
namespace App\Application\Http\Controllers;
use App\Application\Http\Resources\AppointmentResource;
use App\Domain\Services\AppointmentService;
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
            'data'=>AppointmentResource::collection($appointments)
            ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->getAppointmentById($id);
        return response()->json([
            'data'=> new AppointmentResource($appointment) //Modify it as needed
            ], 200);
    }

    public function store(): JsonResponse
    {
        $appointment = $this->AppointmentService->createAppointment(request()->all());
        return response()->json([
            'data'=> new AppointmentResource($appointment) //Modify it as needed
            ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->updateAppointment($id, request()->all());
        return response()->json([
            'data'=> new AppointmentResource($appointment) //Modify it as needed
            ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $appointment = $this->AppointmentService->deleteAppointment($id);
        return response()->json([
            'data'=> new AppointmentResource($appointment) //Modify it as needed
            ], 200);
    }
}
