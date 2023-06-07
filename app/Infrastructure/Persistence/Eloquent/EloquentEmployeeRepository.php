<?php


namespace App\Infrastructure\Persistence\Eloquent;


use App\Domain\Models\Employee;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{

    public function getEmployeeList(): LengthAwarePaginator
    {
        return Employee::query()->paginate(10);
    }

    public function getEmployeeListByDepId(int $dep_id): array
    {
        return Employee::query()->where('cur_dep', '=', $dep_id)->get()->toArray();
    }

    public function getEmployeeListByTitleId(int $title_id): array
    {
        return Employee::query()->where('cur_title', '=', $title_id)->get()->toArray();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        // TODO: Implement getEmployeeById() method.
    }

    public function createEmployee(array $data): Employee
    {
        // TODO: Implement createEmployee() method.
    }

    public function updateEmployee(int $id, array $data): Builder|Model
    {
        // TODO: Implement updateEmployee() method.
    }

    public function deleteEmployee($id): Builder|Model|null
    {
        // TODO: Implement deleteEmployee() method.
    }

    // Never delete this
//    public function editEmployeePermissions(int $id , array $data): Employee|Builder|null
//    {
//        $employee = Employee::query()
//            ->with(['staffings' => function ($query) {
//                $query->with('jobTitle','permissions')->whereNull('end_date')->latest();
//            }])
//            ->find($id);
//        if(!$employee){
//            return $employee;
//        }
//        if(!$employee->staffings->first()){
//            $employee['message'] = "employee no longer works in any department";
//            $employee['status'] = 400;
//            return $employee;
//        }
//
//        // Update the job title (if its updated)
//        if( $employee->cur_title != $data['job_title_id'] ){
//           $employee->staffings()->whereNull('end_date')->first()->update(['job_title_id'=>$data['job_title_id']]);
//           $employee->cur_title = $data['job_title_id'];
//           $employee->save();
//        }
//
//        // Update the permissions including the additional and the new job title permissions (if they are updated)
//        if(array_key_exists('permissions_ids', $data)) {
//            $employee->staffings()->whereNull('end_date')->first()->permissions()->detach();
//            foreach ($data['permissions_ids'] as $permissions_id) {
//                $employee->staffings()->whereNull('end_date')->first()->permissions()->attach($permissions_id, [
//                    'status' => 1,
//                    'created_at' => now(),
//                    'updated_at' => now()
//                ]);
//                $employee->save();
//            }
//        }
//        // Reload the staffings relationship after the update
//        $employee->load([
//            'staffings' => function ($query) {
//                $query->whereNull('end_date');
//            },
//            'staffings.jobTitle',
//            'staffings.permissions'
//        ]);
//
//        return $employee;
//    }

    public function editEmployeePermissions(int $id, array $data): Employee|Builder|null
    {
        $employee = Employee::query()
            ->with(['staffings' => function ($query) {
                $query->with('jobTitle', 'permissions')->whereNull('end_date')->latest();
            }])
            ->find($id);
        if (!$employee) {
            return $employee;
        }
        if (!$employee->staffings->first()) {
            $employee['message'] = "employee no longer works in any department";
            $employee['status'] = 400;
            return $employee;
        }


        $current_job_title_permissions_ids = null;
        $new_job_title_permissions_ids = null;
        $new_additional_permissions_ids = null;

        $current_job_title_permissions = $employee->staffings->first()->jobTitle->permissions;
        foreach ($current_job_title_permissions as $current_job_title_permission)
            $current_job_title_permissions_ids[] = $current_job_title_permission->perm_id;


        // Update the job title (if its updated)
        if (array_key_exists('job_title_id', $data)) {
            if ($employee->cur_title != $data['job_title_id']) {

                if (!empty($current_job_title_permissions_ids)) {
                    $employee->staffings->first()->permissions()
                        ->wherePivotIn('perm_id', $current_job_title_permissions_ids)
                        ->wherePivot('status', 0)
                        ->detach();
                }
                $employee->save();

                $employee->staffings->first()->update(['job_title_id' => $data['job_title_id']]);
                $employee->cur_title = $data['job_title_id'];
                $employee->save();

                // For updated permissions
                $eloquentJobTitleRepository = new EloquentJobTitleRepository();
                $new_job_title_permissions = $eloquentJobTitleRepository->getJobTitleById($data['job_title_id'])->permissions;
                foreach ($new_job_title_permissions as $new_job_title_permission)
                    $new_job_title_permissions_ids[] = $new_job_title_permission->perm_id;
            }
        }

        // Update the additional permissions (if they are updated)
        if (array_key_exists('additional_permissions_ids', $data)) {

            if (empty($data['additional_permissions_ids'])) {
                $employee->staffings->first()->permissions()
                    ->wherePivot('status', 1)
                    ->detach();
            } else {
                foreach ($data['additional_permissions_ids'] as $additional_permissions_id) {
                    if ($new_job_title_permissions_ids == null) {
                        if (in_array($additional_permissions_id, $current_job_title_permissions_ids)) {
                            $employee->staffings->first()->permissions()
                                ->wherePivot('perm_id', $additional_permissions_id)
                                ->detach();
                        } else {
                            $new_additional_permissions_ids[] = $additional_permissions_id;
                        }
                    } else if (!in_array($additional_permissions_id, $new_job_title_permissions_ids)) { //TODO if id is in deleted array !
                        $new_additional_permissions_ids[] = $additional_permissions_id;
                    }
                }
            }
        }

        if (array_key_exists('deleted_permissions_ids', $data)) {
            foreach ($data['deleted_permissions_ids'] as $deleted_permissions_id) {
                if (($new_job_title_permissions_ids !== null && in_array($deleted_permissions_id, $new_job_title_permissions_ids)) ||
                    ($current_job_title_permissions_ids !== null && in_array($deleted_permissions_id, $current_job_title_permissions_ids)) &&
                    !($employee->staffings->first()->permissions()->wherePivot('perm_id', $deleted_permissions_id)->wherePivot('status', 0)->exists())) {
                    $employee->staffings->first()->permissions()->attach($deleted_permissions_id, [
                        'status' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        if ($new_additional_permissions_ids != null) {
            $employee->staffings->first()->permissions()
                ->wherePivot('status', 1)
                ->detach();
            foreach ($new_additional_permissions_ids as $new_additional_permissions_id) {
                $employee->staffings->first()->permissions()->attach($new_additional_permissions_id, [
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $employee->save();
            }
        }

        // Reload the staffings relationship after the update
        $employee->load([
            'staffings' => function ($query) {
                $query->whereNull('end_date');
            },
            'staffings.jobTitle.permissions',
            'staffings.permissions'
        ]);

        return $employee;
    }
}
