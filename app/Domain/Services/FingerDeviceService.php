<?php

namespace App\Domain\Services;

use App\Domain\Repositories\FingerDeviceRepositoryInterface;
use App\Domain\Models\FingerDevice;
use Illuminate\Database\Eloquent\Builder;

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

    public function getFingerDeviceById(int $id): FingerDevice|Builder|null
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
}