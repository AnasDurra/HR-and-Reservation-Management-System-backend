<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

interface EmployeeRepositoryInterface
{
    public function getEmployeeList(): array;

    public function getEmployeeById(int $id): Employee|Builder|null;

    public function createEmployee(array $data): Employee|Builder|null;

    public function updateEmployee(int $id, array $data): Employee|Builder|null;

    public function deleteEmployee($id): Employee|Builder|null;

    public function getEmployeeListByDepId(int $dep_id): array;
}
