<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\StoreEmployeeRequest;
use App\Application\Http\Resources\EmployeeBriefResource;
use App\Application\Http\Resources\EmployeeDetailsResource;
use App\Application\Http\Resources\EmployeeJobTitleResource;
use App\Domain\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $EmployeeService)
    {
        $this->employeeService = $EmployeeService;
    }

    public function index(): AnonymousResourceCollection
    {
        $employees = $this->employeeService->getEmployeeList();
        return EmployeeBriefResource::collection($employees);
    }

    public function show(int $id): EmployeeDetailsResource
    {
        $employee = $this->employeeService->getEmployeeById($id);
        return new EmployeeDetailsResource($employee);
    }

    public function store(StoreEmployeeRequest $request): EmployeeBriefResource
    {
        $validated = $request->validated();
        $employee = $this->employeeService->createEmployee($validated);
        return new EmployeeBriefResource($employee);
    }

    public function update(int $id): JsonResponse
    {
        $employee = $this->employeeService->updateEmployee($id, request()->all());
        return response()->json([
            'data' => new EmployeeDetailsResource($employee) //Modify it as needed
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $employee = $this->employeeService->deleteEmployee($id);
        return response()->json([
            'data' => new EmployeeDetailsResource($employee) //Modify it as needed
        ], 200);
    }

    public function editPermissions(int $id): JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'job_title_id' => ['sometimes',
                Rule::exists('job_titles', 'job_title_id')->whereNull('deleted_at'),
            ],
            'additional_permissions_ids' => ['sometimes', 'array'],
            'additional_permissions_ids.*' => ['integer', 'exists:permissions,perm_id'],
            'deleted_permissions_ids' => ['sometimes', 'array', 'min:1'],
            'deleted_permissions_ids.*' => ['integer', 'exists:permissions,perm_id'],
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'errors' => $errors
            ], 400);
        }
        $employee = $this->employeeService->editEmployeePermissions($id, request()->all());
        if (!$employee) {
            return response()->json([
                'message' => 'employee not found'
            ], 404);
        }
        if ($employee['status'] == 400) {
            return response()->json([
                'message' => $employee['message']
            ], 400);
        }

        return response()->json([
            'data' => new EmployeeJobTitleResource($employee)
        ], 200);
    }
}
