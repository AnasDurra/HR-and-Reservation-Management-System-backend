<?php


namespace App\Infrastructure\Persistence\Eloquent;


use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use MongoDB\Driver\BulkWrite;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{

    public function getEmployeeList(): array
    {
        return Employee::all()->toArray();
    }

    public function getEmployeeListByDepId(int $dep_id): array
    {
        return Employee::query()->where('cur_dep','=',$dep_id)->get()->toArray();
    }

    public function getEmployeeListByTitleId(int $title_id): array
    {
        return Employee::query()->where('cur_title','=',$title_id)->get()->toArray();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        // TODO: Implement getEmployeeById() method.
    }

    public function createEmployee(array $data): Employee
    {
        // TODO: Implement createEmployee() method.
    }

    public function updateEmployee(int $id, array $data): bool
    {
        // TODO: Implement updateEmployee() method.
    }

    public function deleteEmployee($id): bool
    {
        // TODO: Implement deleteEmployee() method.
    }

    public function editEmployeePermissions(int $id , array $data): Employee|Builder|null
    {
        $employee = Employee::query()
            ->with(['staffings' => function ($query) {
                $query->with('jobTitle','permissions')->whereNull('end_date')->latest();
            }])
            ->find($id);
        if(!$employee){
            return $employee;
        }
        if(!$employee->staffings->first()){
            $employee['message'] = "employee no longer works in any department";
            $employee['status'] = 400;
            return $employee;
        }

        // Update the job title (if its updated)
        if( $employee->cur_title != $data['job_title_id'] ){
           $employee->staffings()->whereNull('end_date')->first()->update(['job_title_id'=>$data['job_title_id']]);
           $employee->cur_title = $data['job_title_id'];
           $employee->save();
        }

        // Update the permissions including the additional and the new job title permissions
        $employee->staffings()->whereNull('end_date')->first()->permissions()->detach();
        foreach ($data['permissions_ids'] as $permissions_id){
            $employee->staffings()->whereNull('end_date')->first()->permissions()->attach($permissions_id,[
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $employee->save();
        }
        // Reload the staffings relationship after the update
        $employee->load([
            'staffings' => function ($query) {
                $query->whereNull('end_date');
            },
            'staffings.jobTitle',
            'staffings.permissions'
        ]);

        return $employee;
    }
}
