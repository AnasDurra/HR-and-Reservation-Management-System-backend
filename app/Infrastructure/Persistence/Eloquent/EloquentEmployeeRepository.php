<?php


namespace App\Infrastructure\Persistence\Eloquent;


use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{

    public function getEmployeeList(): array
    {
        return Employee::all()->toArray();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        // TODO: Implement getEmployeeById() method.
    }

    public function createEmployee(array $data): Employee
    {
        // TODO: Implement createEmployee() method.
    }

    public function updateEmployee(int $id, array $data): bool
    {
        // TODO: Implement updateEmployee() method.
    }

    public function deleteEmployee($id): bool
    {
        // TODO: Implement deleteEmployee() method.
    }
}
