<?php

namespace App\Infrastructure\Persistence\Eloquent;
use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Models\Department;

class EloquentDepartmentRepository implements DepartmentRepositoryInterface
{
    public function getList(): array
    {
        $departments=Department::all()->toArray();
        $employeeRepository = new EloquentEmployeeRepository();
        foreach ($departments as &$department) {
            //TODO add this function into Employee Repository :
            /*
       public function getEmployeeListByDepId(int $dep_id): array
        {
            return Employee::query()->where('cur_dep','=',$dep_id)->get()->toArray();
        }
            */
            $department['employees_count']=count($employeeRepository->getEmployeeListByDepId($department['dep_id']));
        }
        return $departments;
    }

    public function getById(int $id): ?Department
    {
        $employeeRepository = new EloquentEmployeeRepository();
        $department = Department::find($id);
        if($department) $department['employees_count'] = count($employeeRepository->getEmployeeListByDepId($department['dep_id']));
        return $department;
    }

    public function create(array $data): Department
    {
        $department= Department::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
        return $department;
    }

    public function update(int $id, array $data): Department
    {
        $department = Department::find($id);
        $department->name = $data['name'] ?? $department->name;
        $department->description = $data['description'] ?? $department->description;
        $department->save();
        return $department;
    }

    public function delete($id): Department
    {
        $employeeRepository = new EloquentEmployeeRepository();
        $department =Department::find($id);
        $department['employees_count']= count($employeeRepository->getEmployeeListByDepId($department['dep_id']));
        if($department['employees_count']>0){
            return $department;
        }
        $filteredJobVacancies = [];
        foreach ($department->jobVacancies as $jobVacancy){
            if($jobVacancy->vacancyStatus['vacancy_status_id']==1) {
                $filteredJobVacancies[] = $jobVacancy;
            }
        }
        unset($department['jobVacancies']);
        if(!empty($filteredJobVacancies)){
            $department['message']='There is one or more opened job vacancies';
            $department['jobVacancies']=$filteredJobVacancies;
            return $department;
        }
        $department->delete();
        return $department;
    }
}
