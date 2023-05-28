<?php
namespace App\Domain\Services;

use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;
use App\Infrastructure\Persistence\Eloquent\EloquentFingerDeviceRepository;
use Illuminate\Database\Eloquent\Builder;
use Rats\Zkteco\Lib\ZKTeco;

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

    public function getEmployeeListByDepId($dep_id): array
    {
        return $this->employeeRepository->getEmployeeListByDepId($dep_id);
    }

    public function getEmployeeListByTitleId($title_id): array
    {
        return $this->employeeRepository->getEmployeeListByTitleId($title_id);
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return $this->employeeRepository->getEmployeeById($id);
    }

    public function createEmployee(array $data): Employee|null
    {
        $employee = $this->employeeRepository->createEmployee($data);

        // Add employee to the finger device
        $fingerDeviceService = new FingerDeviceService(new EloquentFingerDeviceRepository());
        $fingerDeviceService->addEmployeeToFingerDevice($employee['emp_id']);

        return $employee;
    }

    public function updateEmployee(int $id, array $data): bool
    {
        return $this->employeeRepository->updateEmployee($id, $data);
    }

    public function deleteEmployee($id): bool
    {
        return $this->employeeRepository->deleteEmployee($id);
    }

    public function editEmployeePermissions(int $id , array $data): Employee|Builder|null
    {
        return $this->employeeRepository->editEmployeePermissions($id , $data);
    }




}
