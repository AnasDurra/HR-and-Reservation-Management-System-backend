<?php

namespace App\Domain\Services;

use App\Domain\Repositories\FingerDeviceRepositoryInterface;
use App\Domain\Models\FingerDevice;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeRepository;
use Illuminate\Database\Eloquent\Builder;
use Rats\Zkteco\Lib\ZKTeco;

class FingerDeviceService
{
    private FingerDeviceRepositoryInterface $FingerDeviceRepository;

    public function __construct(FingerDeviceRepositoryInterface $FingerDeviceRepository)
    {
        $this->FingerDeviceRepository = $FingerDeviceRepository;
    }

    public function getFingerDeviceList(): array
    {
        return $this->FingerDeviceRepository->getFingerDeviceList();
    }

    public function getFingerDeviceById(int $id): FingerDevice|null
    {
        return $this->FingerDeviceRepository->getFingerDeviceById($id);
    }

    public function createFingerDevice(array $data): FingerDevice|Builder|null
    {
        return $this->FingerDeviceRepository->createFingerDevice($data);
    }

    public function updateFingerDevice(int $id, array $data): FingerDevice|Builder|null
    {
        return $this->FingerDeviceRepository->updateFingerDevice($id, $data);
    }

    public function deleteFingerDevice($id): FingerDevice|Builder|null
    {
        return $this->FingerDeviceRepository->deleteFingerDevice($id);
    }



    public function addEmployeeToFingerDevice(int $emp_id): bool|null
    {
        $employeeService = new EmployeeService(new EloquentEmployeeRepository());
        $employee = $employeeService->getEmployeeById($emp_id);
        $fingerDevices = $this->getFingerDeviceList();

        if (!$fingerDevices || !$employee) return null;

        foreach ($fingerDevices as $fingerDevice) {

            $device = new ZKTeco($fingerDevice->ip, 4370);
            $device->connect();
            $deviceUsers = collect($device->getUser())->pluck('uid');

            $employee_user_name = $employee->user()->username;
            if (!($deviceUsers->contains($employee->emp_id))) {
                $device->setUser($employee->emp_id, $employee->emp_id, $employee_user_name, '', '0', '0');
            }
        }

        return true;
    }

    public function deleteEmployeeFromFingerDevice(int $emp_id): bool|null
    {
        $fingerDevices = $this->getFingerDeviceList();

        if (!$fingerDevices) return null;

        foreach ($fingerDevices as $fingerDevice) {

            $device = new ZKTeco($fingerDevice->ip, 4370);
            $device->connect();
            $deviceUsers = collect($device->getUser())->pluck('uid');

            if (($deviceUsers->contains($emp_id))) {
                $device->removeUser($emp_id);
            }
        }

        return true;
    }
}
