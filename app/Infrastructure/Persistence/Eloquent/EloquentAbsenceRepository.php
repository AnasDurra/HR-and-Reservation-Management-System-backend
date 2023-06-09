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
        return Absence::with(['employee','absenceStatus'])->latest('absence_date')->get();
    }

    public function getAbsenceById(int $id): Absence|Builder|null
    {
        $absence = Absence::query()->with(['employee','absenceStatus'])->find($id);
        if(!$absence)
            return null;

        return $absence;
    }

    public function createAbsence(array $data): Absence|Builder|null
    {
        $absence = Absence::query()->with(['employee','absenceStatus'])
            ->where('emp_id',$data['emp_id'])->where('absence_date',$data['absence_date'])->first();
        if($absence){
            $absence["message"]="Employee has already registered absent";
            return $absence;
        }

        $absence = Absence::query()->create([
            'emp_id' => $data['emp_id'],
            'absence_status_id' => 2,
            'absence_date' => $data['absence_date'] ?? \DateTime::createFromFormat('Y-m-d', now()),
        ]);

        return $absence->load('employee','absenceStatus');
    }

    public function updateAbsenceStatus($id,$status): Absence|Builder|null
    {
        $absence = Absence::query()->find($id);
        if(!$absence)
            return null;

        $absence->absence_status_id = $status;
        $absence->save();

        return $absence->load('employee','absenceStatus');
    }

    public function getEmployeeAbsences($emp_id): Collection|null
    {
        $eloquentEmployeeRepository = new EloquentEmployeeRepository();
        $employee = $eloquentEmployeeRepository->getEmployeeById($emp_id);

        if(!$employee) return null;

        return Absence::query()
            ->with(['employee','absenceStatus'])
            ->latest('absence_date')
            ->get()
            ->map(function ($absence) {
                $absence->employee->full_name = $absence->employee->getFullNameAttribute();
                return $absence;
            });
    }
}
