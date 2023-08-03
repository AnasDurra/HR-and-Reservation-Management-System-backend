<?php
namespace App\Application\Http\Controllers;
use App\Application\Http\Resources\ClinicResource;
use App\Domain\Services\ClinicService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{
    private ClinicService $ClinicService;

    public function __construct(ClinicService $ClinicService)
    {
        $this->ClinicService = $ClinicService;
    }

    public function index(): JsonResponse
    {
        $clinics = $this->ClinicService->getClinicList();
        return response()->json([
            'data'=>ClinicResource::collection($clinics) //Modify it as needed
            ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $clinic = $this->ClinicService->getClinicById($id);
        return response()->json([
            'data'=> new ClinicResource($clinic) //Modify it as needed
            ], 200);
    }

    public function store(): JsonResponse
    {
        $clinic = $this->ClinicService->createClinic(request()->all());
        return response()->json([
            'data'=> new ClinicResource($clinic) //Modify it as needed
            ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $clinic = $this->ClinicService->updateClinic($id, request()->all());
        return response()->json([
            'data'=> new ClinicResource($clinic) //Modify it as needed
            ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $clinic = $this->ClinicService->deleteClinic($id);
        return response()->json([
            'data'=> new ClinicResource($clinic) //Modify it as needed
            ], 200);
    }
}