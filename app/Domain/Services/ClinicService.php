<?php

namespace App\Domain\Services;

use App\Domain\Repositories\ClinicRepositoryInterface;
use App\Domain\Models\CD\Clinic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ClinicService
{
    private ClinicRepositoryInterface $ClinicRepository;

    public function __construct(ClinicRepositoryInterface $ClinicRepository)
    {
        $this->ClinicRepository = $ClinicRepository;
    }

    public function getClinicList(): Collection
    {
        return $this->ClinicRepository->getClinicList();
    }

    public function getClinicById(int $id): Clinic|Builder|null
    {
        return $this->ClinicRepository->getClinicById($id);
    }

    public function createClinic(array $data): Clinic|Builder|null
    {
        return $this->ClinicRepository->createClinic($data);
    }

    public function updateClinic(int $id, array $data): Clinic|Builder|null
    {
        return $this->ClinicRepository->updateClinic($id, $data);
    }

    public function deleteClinic($id): Clinic|Builder|null
    {
        return $this->ClinicRepository->deleteClinic($id);
    }
}
