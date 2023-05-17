<?php

namespace App\Domain\Repositories;

use App\Domain\Models\JobTitlePermission;
use Illuminate\Database\Eloquent\Builder;

interface JobTitlePermissionRepositoryInterface
{
    public function getJobTitlePermissionList(): array;

    public function getJobTitlePermissionById(int $id): JobTitlePermission|Builder|null;

    public function createJobTitlePermission(array $data): JobTitlePermission|Builder|null;

    public function updateJobTitlePermission(int $id, array $data): JobTitlePermission|Builder|null;

    public function deleteJobTitlePermission($job_title_id): JobTitlePermission|Builder|null;
}
