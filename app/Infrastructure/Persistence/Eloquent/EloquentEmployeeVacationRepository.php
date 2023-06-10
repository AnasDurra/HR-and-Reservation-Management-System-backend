<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\EmployeeVacationRepositoryInterface;
use App\Domain\Models\EmployeeVacation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentEmployeeVacationRepository implements EmployeeVacationRepositoryInterface
{
    public function getEmployeeVacationList(): Collection
    {
        $results = EmployeeVacation::query()
            ->with('employee')
            ->latest('start_date')
            ->paginate(10);

        $modifiedResults = $results->getCollection()->map(function ($employee_vacation) {
            $employee_vacation->employee->full_name = $employee_vacation->employee->getFullNameAttribute();

            $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
            if ($cur_dep !== null) {
                $employee_vacation->employee->cur_dep = $cur_dep->name;
            }

            $cur_title = $employee_vacation->employee->getCurrentJobTitleAttribute();
            if ($cur_title !== null) {
                $employee_vacation->employee->cur_title = $cur_title->name;
            }

            return $employee_vacation;
        });

        $results->setCollection($modifiedResults);

        return collect($results);

    }

    public function getEmployeeVacationById(int $id): EmployeeVacation|Builder|null
    {
        $employee_vacation = EmployeeVacation::query()
            ->with('employee')
            ->find($id);

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cut_title = $employee_vacation->employee->getCurrentJobTitleAttribute();
        if($cut_title !== null){
            $employee_vacation->employee->cur_title = $cut_title->name;
        }

        return $employee_vacation;
    }

    public function createEmployeeVacation(array $data): EmployeeVacation|Builder|null
    {
        $employee_vacation = EmployeeVacation::query()->with('employee')->create([
            "emp_id" => $data["emp_id"],
            "start_date" => $data["start_date"],
            "total_days" => $data["total_days"],
            "remaining_days" => $data["remaining_days"] ?? $data["total_days"]
        ]);

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cut_title = $employee_vacation->employee->getCurrentJobTitleAttribute();
        if($cut_title !== null){
            $employee_vacation->employee->cur_title = $cut_title->name;
        }

        return $employee_vacation;
    }

    public function updateEmployeeVacation(int $id, array $data): EmployeeVacation|Builder|null
    {
        $employee_vacation = EmployeeVacation::query()->find($id);

        if(!$employee_vacation) return null;

        $employee_vacation["emp_id"] = $data["emp_id"] ?? $employee_vacation["emp_id"];
        $employee_vacation["start_date"] = $data["start_date"] ?? $employee_vacation["start_date"];
        $employee_vacation["total_days"] = $data["total_days"] ?? $employee_vacation["total_days"];
        $employee_vacation["remaining_days"] = $data["remaining_days"] ?? $employee_vacation["remaining_days"];
        $employee_vacation->save();

        $employee_vacation->employee();
        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cut_title = $employee_vacation->employee->getCurrentJobTitleAttribute();
        if($cut_title !== null){
            $employee_vacation->employee->cur_title = $cut_title->name;
        }

        return $employee_vacation;
    }

    public function deleteEmployeeVacation($id): EmployeeVacation|Builder|null
    {
        $employee_vacation = EmployeeVacation::query()->with('employee')->find($id);

        if(!$employee_vacation) return null;

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cur_dep = $employee_vacation->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $employee_vacation->employee->cur_dep = $cur_dep->name;
        }

        $cut_title = $employee_vacation->employee->getCurrentJobTitleAttribute();
        if($cut_title !== null){
            $employee_vacation->employee->cur_title = $cut_title->name;
        }

        $employee_vacation->delete();
        return $employee_vacation;
    }

    public function getEmployeeVacations($emp_id): array
    {
        $eloquentEmployeeRepository = new EloquentEmployeeRepository();
        $employee = $eloquentEmployeeRepository->getEmployeeById($emp_id);

        if(!$employee) return ["message"=>'employee not found'];
        return EmployeeVacation::query()->where('emp_id',$emp_id)->latest('start_date')->get()->toArray();
    }
}
