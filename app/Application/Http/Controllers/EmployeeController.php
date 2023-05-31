<?php
namespace App\Application\Http\Controllers;
use App\Application\Http\Resources\EmployeeResource;
use App\Domain\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
class EmployeeController extends Controller
{
    private EmployeeService $EmployeeService;

    public function __construct(EmployeeService $EmployeeService)
    {
        $this->EmployeeService = $EmployeeService;
    }

    public function index(): JsonResponse
    {
        $employees = $this->EmployeeService->getEmployeeList();
        return response()->json([
            'data'=>EmployeeResource::collection($employees) //Modify it as needed
            ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $employee = $this->EmployeeService->getEmployeeById($id);
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function store(): JsonResponse
    {
        $employee = $this->EmployeeService->createEmployee(request()->all());
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $employee = $this->EmployeeService->updateEmployee($id, request()->all());
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $employee = $this->EmployeeService->deleteEmployee($id);
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }
}
