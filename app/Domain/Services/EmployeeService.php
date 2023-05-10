<?php


namespace App\Domain\Services;


use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;

class EmployeeService
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getEmployeeList(): array
    {
        return $this->employeeRepository->getEmployeeList();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    public function createEmployee(array $data): Employee
    {
        return $this->employeeRepository->createEmployee($data);
    }

    public function updateEmployee(int $id, array $data): bool
    {
        return $this->employeeRepository->updateEmployee($id, $data);
    }

    public function deleteEmployee($id): bool
    {
        return $this->employeeRepository->deleteEmployee($id);
    }
}
