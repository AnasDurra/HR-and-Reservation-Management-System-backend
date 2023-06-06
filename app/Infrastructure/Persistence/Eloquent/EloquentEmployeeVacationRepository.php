<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\EmployeeVacationRepositoryInterface;
use App\Domain\Models\EmployeeVacation;
use Illuminate\Database\Eloquent\Builder;

class EloquentEmployeeVacationRepository implements EmployeeVacationRepositoryInterface
{
    public function getEmployeeVacationList(): array
    {
        return EmployeeVacation::with('employee')->get()->toArray();
    }

    public function getEmployeeVacationById(int $id): EmployeeVacation|Builder|null
    {
        return EmployeeVacation::query()->with('employee')->find($id);
    }

    public function createEmployeeVacation(array $data): EmployeeVacation|Builder|null
    {
        return EmployeeVacation::query()->with('employee')->create([
            "emp_id" => $data["emp_id"],
            "start_date" => $data["start_date"],
            "total_days" => $data["total_days"],
            "remaining_days" => $data["remaining_days"] ?? 0
        ]);
    }

    public function updateEmployeeVacation(int $id, array $data): EmployeeVacation|Builder|null
    {
        $vacation = EmployeeVacation::query()->find($id);

        if(!$vacation) return null;

        $vacation["emp_id"] = $data["emp_id"] ?? $vacation["emp_id"];
        $vacation["start_date"] = $data["start_date"] ?? $vacation["start_date"];
        $vacation["total_days"] = $data["total_days"] ?? $vacation["total_days"];
        $vacation["remaining_days"] = $data["remaining_days"] ?? $vacation["remaining_days"];
        $vacation->save();

        $vacation->employee();
        return $vacation;
    }

    public function deleteEmployeeVacation($id): EmployeeVacation|Builder|null
    {
        $vacation = EmployeeVacation::query()->with('employee')->find($id);

        if(!$vacation) return null;

        $vacation->delete();
        return $vacation;
    }

    public function getEmployeeVacations($emp_id): array
    {
//        $eloquentEmployeeRepository = new EloquentEmployeeRepository();
//        $employee = $eloquentEmployeeRepository->getEmployeeById($emp_id);
//
//        if(!$employee) return ["message"=>'employee not found'];
        return EmployeeVacation::query()->where('emp_id',$emp_id)->latest('start_date')->get()->toArray();
    }
}
