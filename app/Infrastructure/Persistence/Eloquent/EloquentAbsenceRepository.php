<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\AbsenceRepositoryInterface;
use App\Domain\Models\Absence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentAbsenceRepository implements AbsenceRepositoryInterface
{
    public function getAbsenceList(): Collection
    {
        $results = Absence::query()->
        with(['employee','absenceStatus'])
            ->latest('absence_date')
            ->paginate(10);

        $modifiedResults = $results->getCollection()->map(function ($employee_absence) {
            $employee_absence->employee->full_name = $employee_absence->employee->getFullNameAttribute();

            $cur_dep = $employee_absence->employee->getCurrentDepartmentAttribute();
            if ($cur_dep !== null) {
                $employee_absence->employee->cur_dep = $cur_dep->name;
            }

            $cur_title = $employee_absence->employee->getCurrentJobTitleAttribute();
            if ($cur_title !== null) {
                $employee_absence->employee->cur_title = $cur_title->name;
            }

            $employee_absence["absenceStatus"] =$employee_absence->absenceStatus->name;

            return $employee_absence;
        });

        $results->setCollection($modifiedResults);

        return collect($results);
    }

    public function getAbsenceById(int $id): Absence|Builder|null
    {
        $absence = Absence::query()->with(['employee','absenceStatus'])->find($id);
        if(!$absence)
            return null;

        $absence->employee->full_name = $absence->employee->getFullNameAttribute();

        $cur_dep = $absence->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $absence->employee->cur_dep = $cur_dep->name;
        }

        $cur_title = $absence->employee->getCurrentJobTitleAttribute();
        if ($cur_title !== null) {
            $absence->employee->cur_title = $cur_title->name;
        }

        $absence["absenceStatus"] =$absence->absenceStatus->name;

        return $absence;
    }

    public function createAbsence(array $data): Absence|Builder|null
    {
        $absence = Absence::query()->with(['employee','absenceStatus'])
            ->where('emp_id',$data['emp_id'])->where('absence_date',$data['absence_date'])->first();
        if($absence){
            $absence->employee->full_name = $absence->employee->getFullNameAttribute();

            $cur_dep = $absence->employee->getCurrentDepartmentAttribute();
            if ($cur_dep !== null) {
                $absence->employee->cur_dep = $cur_dep->name;
            }

            $cur_title = $absence->employee->getCurrentJobTitleAttribute();
            if ($cur_title !== null) {
                $absence->employee->cur_title = $cur_title->name;
            }

            $absence["absenceStatus"] =$absence->absenceStatus->name;

            $absence["message"]="Employee has already registered absent";
            return $absence;
        }

        $absence = Absence::query()->create([
            'emp_id' => $data['emp_id'],
            'absence_status_id' => 2,
            'absence_date' => $data['absence_date'] ?? \DateTime::createFromFormat('Y-m-d', now()),
        ]);

        $absence->load('employee','absenceStatus');
        $absence->employee->load('vacations');

        $absence->employee->full_name = $absence->employee->getFullNameAttribute();

        $cur_dep = $absence->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $absence->employee->cur_dep = $cur_dep->name;
        }

        $cur_title = $absence->employee->getCurrentJobTitleAttribute();
        if ($cur_title !== null) {
            $absence->employee->cur_title = $cur_title->name;
        }

        $absence["absenceStatus"] =$absence->absenceStatus->name;


        foreach ($absence->employee->vacations as $vacation) {
            if ($vacation->remaining_days != 0) {
                $vacation->remaining_days--;
                $vacation->save();

                $absence["message"] = "employee is on vacation";
                $absence->delete();
                return $absence;
            }
        }

        return $absence;
    }

    public function updateAbsenceStatus($id,$status): Absence|Builder|null
    {
        $absence = Absence::query()->with(['employee','absenceStatus'])->find($id);
        if(!$absence)
            return null;

        $absence->absence_status_id = $status;
        $absence->save();

        $absence->employee->full_name = $absence->employee->getFullNameAttribute();

        $cur_dep = $absence->employee->getCurrentDepartmentAttribute();
        if ($cur_dep !== null) {
            $absence->employee->cur_dep = $cur_dep->name;
        }

        $cur_title = $absence->employee->getCurrentJobTitleAttribute();
        if ($cur_title !== null) {
            $absence->employee->cur_title = $cur_title->name;
        }

        $absence->load('absenceStatus');
        $absence["absenceStatus"] =$absence->absenceStatus->name;

        return $absence;
    }

    public function getEmployeeAbsences($emp_id): Collection|null
    {
        $eloquentEmployeeRepository = new EloquentEmployeeRepository();
        $employee = $eloquentEmployeeRepository->getEmployeeById($emp_id);

        if(!$employee) return null;

        return Absence::query()
            ->with(['employee','absenceStatus'])
            ->latest('absence_date')
            ->where('emp_id',$emp_id)
            ->get()
            ->map(function ($absence){
                $cur_dep = $absence->employee->getCurrentDepartmentAttribute();
                if ($cur_dep !== null) {
                    $absence->employee->cur_dep = $cur_dep->name;
                }
                return $absence;
            })
            ->map(function ($absence){
                $cur_title = $absence->employee->getCurrentJobTitleAttribute();
                if ($cur_title !== null) {
                    $absence->employee->cur_title = $cur_title->name;
                }
                return $absence;
            })
            ->map(function ($absence){
                $absence["absenceStatus"] =$absence->absenceStatus->name;
                return $absence;
            });
    }
}
