<?php

namespace App\Domain\Services;

use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class EmployeeService
{
    /** @var EmployeeRepositoryInterface */
    private $EmployeeRepository;

    public function __construct(EmployeeRepositoryInterface $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }

    public function getEmployeeList(): array
    {
        return $this->EmployeeRepository->getEmployeeList();
    }

    public function getEmployeeById(int $id): Employee|Builder|null
    {
        return $this->EmployeeRepository->getEmployeeById($id);
    }

    public function createEmployee(array $data): Employee|Builder|null
    {
        return $this->EmployeeRepository->createEmployee($data);
    }

    public function updateEmployee(int $id, array $data): Employee|Builder|null
    {
        return $this->EmployeeRepository->updateEmployee($id, $data);
    }

    public function deleteEmployee($id): Employee|Builder|null
    {
        return $this->EmployeeRepository->deleteEmployee($id);
    }
}