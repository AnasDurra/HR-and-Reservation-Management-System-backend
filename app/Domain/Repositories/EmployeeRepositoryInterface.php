<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface EmployeeRepositoryInterface
{
    public function getEmployeeList(): LengthAwarePaginator;

    public function getEmployeeListByDepId(int $dep_id): array;

    public function getEmployeeListByTitleId(int $title_id): array;

    public function getEmployeeById(int $id): Builder|Model;

    public function createEmployee(array $data): Builder|Model;

    public function updateEmployee(int $id, array $data): Builder|Model;

    public function deleteEmployee($id): Builder|Model|null;

    public function editEmployeeCredentials(int $id , array $data): Employee|Builder|null;

    public function editEmployeePermissions(int $id , array $data): Employee|Builder|null;

}
