<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{
    public function getEmployeeList(): array
    {
        // TODO: Implement the logic to retrieve a list of Employees
    }

    public function getEmployeeById(int $id): Employee|Builder|null
    {
        // TODO: Implement the logic to retrieve a Employee by ID
    }

    public function createEmployee(array $data): Employee|Builder|null
    {
        // TODO: Implement the logic to create a Employee
    }

    public function updateEmployee(int $id, array $data): Employee|Builder|null
    {
        // TODO: Implement the logic to update a Employee
    }

    public function deleteEmployee($id): Employee|Builder|null
    {
        // TODO: Implement the logic to delete a Employee
    }

    public function getEmployeeListByDepId(int $dep_id): array
    {
        return Employee::query()->where('cur_dep','=',$dep_id)->get()->toArray();
    }

}
