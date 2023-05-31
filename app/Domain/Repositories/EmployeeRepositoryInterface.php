<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

interface EmployeeRepositoryInterface
{
    public function getEmployeeList(): array;

    public function getEmployeeListByDepId(int $dep_id): array;

    public function getEmployeeListByTitleId(int $title_id): array;

    public function getEmployeeById(int $id): ?Employee;

    public function createEmployee(array $data): Employee;

    public function updateEmployee(int $id, array $data): bool;

    public function deleteEmployee($id): bool;

    public function editEmployeePermissions(int $id , array $data): Employee|Builder|null;
}