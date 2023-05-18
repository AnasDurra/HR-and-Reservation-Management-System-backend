<?php
namespace App\Application\Http\Controllers;
use App\Application\Http\Resources\EmployeeResource;
use App\Domain\Services\EmployeeService;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $EmployeeService)
    {
        $this->employeeService = $EmployeeService;
    }

    public function index(): JsonResponse
    {
        $employees = $this->employeeService->getEmployeeList();
        return response()->json([
            'data'=>EmployeeResource::collection($employees) //Modify it as needed
            ], 200);
    }

    public function show(int $id): JsonResponse
    {
        $employee = $this->employeeService->getEmployeeById($id);
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function store(): JsonResponse
    {
        $employee = $this->employeeService->createEmployee(request()->all());
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function update(int $id): JsonResponse
    {
        $employee = $this->employeeService->updateEmployee($id, request()->all());
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $employee = $this->employeeService->deleteEmployee($id);
        return response()->json([
            'data'=> new EmployeeResource($employee) //Modify it as needed
            ], 200);
    }
}
