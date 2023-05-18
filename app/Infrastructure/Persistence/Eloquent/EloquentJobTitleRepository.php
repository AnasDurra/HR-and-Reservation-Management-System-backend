<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\JobTitleRepositoryInterface;
use App\Domain\Models\JobTitle;
use Illuminate\Database\Eloquent\Builder;

class EloquentJobTitleRepository implements JobTitleRepositoryInterface
{
    public function getJobTitleList(): array
    {
        $employeeRepository = new EloquentEmployeeRepository();
        $jobTitles = JobTitle::with('permissions')->get()->toArray();
        foreach ($jobTitles as &$jobTitle)
            $jobTitle['employees_count']=count($employeeRepository->getEmployeeListByTitleId($jobTitle['job_title_id']));

        return $jobTitles;
    }

    public function getJobTitleById(int $id): JobTitle|Builder|null
    {
        $employeeRepository = new EloquentEmployeeRepository();
        $jobTitle = JobTitle::with('permissions')->find($id);
        if($jobTitle) $jobTitle['employees_count']=count($employeeRepository->getEmployeeListByTitleId($jobTitle['job_title_id']));

        return $jobTitle;
    }

    public function createJobTitle(array $data): JobTitle|Builder|null
    {
        $jobTile= JobTitle::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        $jobTitlePermissionRepository =new EloquentJobTitlePermissionRepository();
        foreach ($data['permissions_ids'] as $permission) {
            $jobTitlePermissionRepository->createJobTitlePermission([
                'job_title_id' => $jobTile['job_title_id'],
                'perm_id' => $permission
            ]);
        }
        return $jobTile->load('permissions');
    }

    public function updateJobTitle(int $id, array $data): JobTitle|Builder|null
    {
        $jobTitlePermissionRepository = new EloquentJobTitlePermissionRepository();

        $jobTile = JobTitle::find($id);
        $jobTile->name = $data['name'] ?? $jobTile->name;
        $jobTile->description = $data['description'] ?? $jobTile->description;
        $jobTile->save();
        $jobTitlePermissionRepository->deleteJobTitlePermission($id);

        foreach ($data['permissions_ids'] as $permission) {
            $jobTitlePermissionRepository->createJobTitlePermission([
                'job_title_id' => $jobTile['job_title_id'],
                'perm_id' => $permission
            ]);
        }
        return $jobTile->load('permissions');
    }

    public function deleteJobTitle($id): JobTitle|Builder|null
    {
        $employeeRepository = new EloquentEmployeeRepository();

        $jobTitle = JobTitle::with('permissions')->find($id);
        if(!$jobTitle) return null;

        $jobTitle['employees_count']=count($employeeRepository->getEmployeeListByTitleId($jobTitle['job_title_id']));
        if($jobTitle['employees_count']>0){
            return $jobTitle;
        }
        //delete records in pivot table
        $jobTitle->permissions()->update(['deleted_at' => now()]);
        //delete the job title record
        $jobTitle->delete();

        return $jobTitle;

    }
}
