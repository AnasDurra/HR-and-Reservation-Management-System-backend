<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\LeaveRepositoryInterface;
use App\Domain\Models\Leave;
use Illuminate\Database\Eloquent\Builder;

class EloquentLeaveRepository implements LeaveRepositoryInterface
{
    public function getLeaveList(): array
    {
        $leaves = Leave::query()->latest('leave_date')->paginate(10);
        foreach ($leaves as $key => $leave) {
            if (!($leave->employee->schedule->time_out <= $leave->leave_time)) {
                $leaveTime = \DateTime::createFromFormat('H:i:s', $leave["leave_time"]);
                $scheduleTimeOut = \DateTime::createFromFormat('H:i:s', $leave->employee->schedule->time_out);
                $duration = $scheduleTimeOut->diff($leaveTime);
                $leave["leaveBefore"] = $duration->format('%H:%I:%S');
            }
            $leave->employee->load('empData');
        }

        return $leaves->toArray();
    }

    public function getLeaveById(int $id): Leave|Builder|null
    {
        $leave = Leave::query()->find($id);

        if(!$leave) return null;

        if (!($leave->employee->schedule->time_out <= $leave->leave_time)) {
            $leaveTime = \DateTime::createFromFormat('H:i:s', $leave["leave_time"]);
            $scheduleTimeOut = \DateTime::createFromFormat('H:i:s', $leave->employee->schedule->time_out);
            $duration = $scheduleTimeOut->diff($leaveTime);

            $leave["leaveBefore"] = $duration->format('%H:%I:%S');
        }

        $leave->employee->load('empData');
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

        $leave = Leave::query()->create([
            'emp_id' => $data['emp_id'],
            'uid' => $data['uid'] ?? 0,
            'state' => $data['state'] ?? 1,
            'status' => $data['status'] ?? 1,
            'leave_time' => $data['leave_time'],
            'leave_date' => $data['leave_date'],
        ]);


        if (!($leave->employee->schedule->time_out <= $leave->leave_time)) {
            $leave["status"] =0;
            $leave->save();
            $leaveTime = \DateTime::createFromFormat('H:i:s', $leave["leave_time"]);
            $scheduleTimeOut = \DateTime::createFromFormat('H:i:s', $leave->employee->schedule->time_out);
            $duration = $scheduleTimeOut->diff($leaveTime);

            $leave["leaveBefore"] = $duration->format('%H:%I:%S');
        }

        $leave->employee->load('empData');
        return $leave;
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


        if (!($leave->employee->schedule->time_out <= $leave->leave_time)) {
            $leave["status"] =0;
            $leave->save();
            $leaveTime = \DateTime::createFromFormat('H:i:s', $leave["leave_time"]);
            $scheduleTimeOut = \DateTime::createFromFormat('H:i:s', $leave->employee->schedule->time_out);
            $duration = $scheduleTimeOut->diff($leaveTime);

            $leave["leaveBefore"] = $duration->format('%H:%I:%S');
        }
        else{
            $leave["status"] =1;
            $leave->save();
        }
        $leave->employee->load('empData');
        return $leave;
    }

    public function deleteLeave($id): Leave|Builder|null
    {
        $leave = $this->getLeaveById($id);

        if(!$leave) return null;

        $leave->delete();
        return $leave;
    }
}
