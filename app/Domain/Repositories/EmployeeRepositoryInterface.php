<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Employee;

interface EmployeeRepositoryInterface
{
    public function getEmployeeList(): array;

    public function getEmployeeById(int $id): ?Employee;

    public function createEmployee(array $data): Employee;

    public function updateEmployee(int $id, array $data): bool;

    public function deleteEmployee($id): bool;
}
