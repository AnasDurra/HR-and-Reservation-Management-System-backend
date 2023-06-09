<?php

namespace App\Domain\Services;

use App\Domain\Repositories\AbsenceRepositoryInterface;
use App\Domain\Models\Absence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AbsenceService
{
    private AbsenceRepositoryInterface $AbsenceRepository;

    public function __construct(AbsenceRepositoryInterface $AbsenceRepository)
    {
        $this->AbsenceRepository = $AbsenceRepository;
    }

    public function getAbsenceList(): Collection
    {
        return $this->AbsenceRepository->getAbsenceList();
    }

    public function getAbsenceById(int $id): Absence|Builder|null
    {
        return $this->AbsenceRepository->getAbsenceById($id);
    }

    public function createAbsence(array $data): Absence|Builder|null
    {
        return $this->AbsenceRepository->createAbsence($data);
    }

    public function updateAbsenceStatus($id,$status): Absence|Builder|null
    {
        return $this->AbsenceRepository->updateAbsenceStatus($id,$status);
    }

    public function getEmployeeAbsences($id): Collection|null
    {
        return $this->AbsenceRepository->getEmployeeAbsences($id);
    }
}
