<?php


namespace App\Infrastructure\Persistence\Eloquent;


use App\Domain\Models\Employee;
use App\Domain\Models\EmploymentStatus;
use App\Domain\Models\JobApplication;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        // initialize the user repository
        try {
            $this->userRepository = app()->make(UserRepositoryInterface::class);
        } catch (ContainerExceptionInterface $e) {
            report($e);
        }
    }

    /**
     */
    public function getEmployeeList(): LengthAwarePaginator
    {
        // implement search, filtration, and pagination
        $employees = Employee::query()
            ->with('user');

        // search by email
        if (request()->has('email')) {
            $employees->whereHas('user', function ($query) {
                $query->where('email', 'like', '%' . request()->get('email') . '%');
            });
        }

        // search by username
        if (request()->has('username')) {
            $employees->whereHas('user', function ($query) {
                $query->where('username', 'like', '%' . request()->get('username') . '%');
            });
        }

        // search by name (full name)
        if (request()->has('name')) {

            // get the name
            $name = request()->get('name');

            // trim & convert to lowercase
            $name = strtolower(trim($name));

            // search after ignoring the case
            $employees->whereHas('jobApplication', function ($query) use ($name) {
                $query->whereHas('empData', function ($query) use ($name) {
                    $query->whereRaw('LOWER(first_name) LIKE ?', ["%$name%"])
                        ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$name%"])
                        ->orWhereRaw('CONCAT(LOWER(first_name), " ", LOWER(last_name)) LIKE ?', ["%$name%"]);
                });
            });
        }

        // filter by scheduleId
        if (request()->has('schedule')) {

            // get the schedules
            $schedules = request()->get('schedule');

            // extract the comma separated values
            $schedules = explode(',', $schedules);

            // convert it to array of integers
            $schedules = array_map('intval', $schedules);

            // filter the result based on schedule IDs
            $employees->whereIn('schedule_id', $schedules);
        }

        // filter by departmentId
        if (request()->has('dep')) {

            // get the departments
            $departments = request()->get('dep');

            // extract the comma separated values
            $departments = explode(',', $departments);

            // convert it to array of integers
            $departments = array_map('intval', $departments);

            // filter the result based on department IDs
            $employees->whereIn('cur_dep', $departments);
        }

        // filter by titleId
        if (request()->has('title')) {

            // get the titles
            $titles = request()->get('title');

            // extract the comma separated values
            $titles = explode(',', $titles);

            // convert it to array of integers
            $titles = array_map('intval', $titles);

            // filter the result based on title IDs
            $employees->whereIn('cur_title', $titles);
        }

        return $employees->paginate(10);

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
        return Employee::query()->findOrFail($id)->first();
    }

    /**
     * @throws Exception
     */
    public function createEmployee(array $data): Builder|Model
    {
        try {
            // start transaction
            DB::beginTransaction();

            // first, user should be created
            $user = $this->userRepository->createUser([
                'user_type_id' => 1,
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $data['password'],
            ]);

            // get the dep_id for the employee from the job vacancy
            // that is associated with the job application
            $dep_id = JobApplication::query()
                ->where('job_app_id', '=', $data['job_app_id'])
                ->firstOrFail()
                ->jobVacancy
                ->dep_id;

            // then, employee should be created
            $employee = Employee::query()->create([
                'user_id' => $user->user_id,
                'job_app_id' => $data['job_app_id'],
                'schedule_id' => $data['schedule_id'],
                'leaves_balance' => $data['leaves_balance'],

                // meta data for employee
                'cur_title' => $data['job_title_id'],
                'cur_dep' => $dep_id,
            ]);

            // create a staffing record for the employee
            $employee->staffings()->create([
                'job_title_id' => $data['job_title_id'],
                'dep_id' => $dep_id,
                'start_date' => $data['start_date'],
            ]);

            // attach an employment status record for the employee (working by default)
            $employee->employmentStatuses()->attach(EmploymentStatus::WORKING, [
                'start_date' => $data['start_date'],
            ]);

            // commit transaction
            DB::commit();

            return $employee;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
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
