<?php

namespace App\Domain\Repositories;

use App\Domain\Models\EmployeeVacation;
use Illuminate\Database\Eloquent\Builder;

interface EmployeeVacationRepositoryInterface
{
    public function getEmployeeVacationList(): array;

    public function getEmployeeVacationById(int $id): EmployeeVacation|Builder|null;

    public function createEmployeeVacation(array $data): EmployeeVacation|Builder|null;

    public function updateEmployeeVacation(int $id, array $data): EmployeeVacation|Builder|null;

    public function deleteEmployeeVacation($id): EmployeeVacation|Builder|null;

    public function getEmployeeVacations($emp_id): array;
}
