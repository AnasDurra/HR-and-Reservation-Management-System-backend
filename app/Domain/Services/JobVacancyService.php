<?php

namespace App\Domain\Services;

use App\Domain\Repositories\JobVacancyRepositoryInterface;
use App\Domain\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;

class JobVacancyService
{
    /** @var JobVacancyRepositoryInterface */
    private $JobVacancyRepository;

    public function __construct(JobVacancyRepositoryInterface $JobVacancyRepository)
    {
        $this->JobVacancyRepository = $JobVacancyRepository;
    }

    public function getJobVacancyList(): array
    {
        return $this->JobVacancyRepository->getJobVacancyList();
    }

    public function getJobVacancyById(int $id): JobVacancy|Builder|null
    {
        return $this->JobVacancyRepository->getJobVacancyById($id);
    }

    public function createJobVacancy(array $data): JobVacancy|Builder
    {
        return $this->JobVacancyRepository->createJobVacancy($data);
    }

    public function updateJobVacancy(int $id, array $data): JobVacancy|Builder
    {
        return $this->JobVacancyRepository->updateJobVacancy($id, $data);
    }

    public function deleteJobVacancy($id): JobVacancy|Builder
    {
        return $this->JobVacancyRepository->deleteJobVacancy($id);
    }
}
