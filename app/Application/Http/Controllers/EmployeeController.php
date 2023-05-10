<?php


namespace App\Application\Http\Controllers;


use App\Application\Http\Resources\EmployeeResource;
use App\Domain\Services\EmployeeService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(): AnonymousResourceCollection
    {
        $employees = $this->employeeService->getEmployeeList();
        return EmployeeResource::collection($employees);
    }

    public function show(int $id): EmployeeResource
    {
        $employee = $this->employeeService->getEmployeeById($id);
        return new EmployeeResource($employee);
    }

    public function store(): EmployeeResource
    {
        $employee = $this->employeeService->createEmployee(request()->all());
        return new EmployeeResource($employee);
    }

    public function update(int $id): EmployeeResource
    {
        $employee = $this->employeeService->updateEmployee($id, request()->all());
        return new EmployeeResource($employee);
    }

    public function destroy(int $id): EmployeeResource
    {
        $employee = $this->employeeService->deleteEmployee($id);
        return new EmployeeResource($employee);
    }
}
