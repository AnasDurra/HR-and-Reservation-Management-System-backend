<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\JobTitlePermissionRepositoryInterface;
use App\Domain\Models\JobTitlePermission;
use Illuminate\Database\Eloquent\Builder;

class EloquentJobTitlePermissionRepository implements JobTitlePermissionRepositoryInterface
{
    public function getJobTitlePermissionList(): array
    {
        // TODO: Implement the logic to retrieve a list of JobTitlePermissions
    }

    public function getJobTitlePermissionById(int $id): JobTitlePermission|Builder|null
    {
        // TODO: Implement the logic to retrieve a JobTitlePermission by ID
    }

    public function createJobTitlePermission(array $data): JobTitlePermission|Builder|null
    {
        $jobTitlePermission =JobTitlePermission::create([
            'job_title_id'=>$data['job_title_id'],
            'perm_id'=>$data['perm_id']
        ]);
        return $jobTitlePermission;
    }

    public function updateJobTitlePermission(int $id, array $data): JobTitlePermission|Builder|null
    {
        //
    }

    public function deleteJobTitlePermission($job_title_id): JobTitlePermission|Builder|null
    {

        JobTitlePermission::where('job_title_id', '=', $job_title_id)->delete();
        return null;
    }
}
