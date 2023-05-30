<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\LeaveRepositoryInterface;
use App\Domain\Models\Leave;
use Illuminate\Database\Eloquent\Builder;

class EloquentLeaveRepository implements LeaveRepositoryInterface
{
    public function getLeaveList(): array
    {
        return Leave::query()->latest()->get()->toArray();
    }

    public function getLeaveById(int $id): Leave|Builder|null
    {
        $leave = Leave::query()->find($id);

        if(!$leave) return null;

        return $leave;
    }

    public function createLeave(array $data): Leave|Builder|null
    {
        if($leave = Leave::query()->where('emp_id',$data['emp_id'])->where('leave_date',$data['leave_date'])
            ->first()
        )
        {
            $leave['message'] = "Employee has already checked-out in this day";
            return $leave;
        }

        $eloquentAttendanceRepository = new EloquentAttendanceRepository();
        if(!($eloquentAttendanceRepository->getEmployeeAttByDate($data['emp_id'],$data['leave_date']))){
            return null;
        }

        return Leave::query()->create([
            'emp_id' => $data['emp_id'],
            'uid' => $data['uid'] ?? 0,
            'state' => $data['state'] ?? 1,
            'leave_time' => $data['leave_time'],
            'leave_date' => $data['leave_date'],
        ]);
    }

    public function updateLeave(int $id, array $data): Leave|Builder|null
    {
        $leave = Leave::query()->find($id);
        if(!$leave) return null;

        $leave['emp_id'] = $data['emp_id'] ?? $leave['emp_id'];
        $leave['state'] = $data['state'] ?? $leave['state'];
        $leave['leave_time'] = $data['leave_time'] ?? $leave['leave_time'];
        $leave['leave_date'] = $data['leave_date'] ?? $leave['leave_date'];
        $leave['status'] = $data['status'] ?? $leave['status'];
        $leave->save();

        return $leave;
    }

    public function deleteLeave($id): Leave|Builder|null
    {
        $leave = Leave::query()->find($id);

        if(!$leave) return null;

        $leave->delete();
        return $leave;
    }
}
