<?php

namespace App\Domain\Services;

use App\Domain\Repositories\JobTitlePermissionRepositoryInterface;
use App\Domain\Models\JobTitlePermission;
use Illuminate\Database\Eloquent\Builder;

class JobTitlePermissionService
{
    /** @var JobTitlePermissionRepositoryInterface */
    private $JobTitlePermissionRepository;

    public function __construct(JobTitlePermissionRepositoryInterface $JobTitlePermissionRepository)
    {
        $this->JobTitlePermissionRepository = $JobTitlePermissionRepository;
    }

    public function getJobTitlePermissionList(): array
    {
        return $this->JobTitlePermissionRepository->getJobTitlePermissionList();
    }

    public function getJobTitlePermissionById(int $id): JobTitlePermission|Builder|null
    {
        return $this->JobTitlePermissionRepository->getJobTitlePermissionById($id);
    }

    public function createJobTitlePermission(array $data): JobTitlePermission|Builder|null
    {
        return $this->JobTitlePermissionRepository->createJobTitlePermission($data);
    }

    public function updateJobTitlePermission(int $id, array $data): JobTitlePermission|Builder|null
    {
        return $this->JobTitlePermissionRepository->updateJobTitlePermission($id, $data);
    }

    public function deleteJobTitlePermission($job_title_id): JobTitlePermission|Builder|null
    {
        return $this->JobTitlePermissionRepository->deleteJobTitlePermission($job_title_id);
    }
}
