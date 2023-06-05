<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\AttendanceRepositoryInterface;
use App\Domain\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;

class EloquentAttendanceRepository implements AttendanceRepositoryInterface
{
    public function getAttendanceList(): array
    {
        return Attendance::query()
            ->with([
                'employee:emp_id,schedule_id,emp_data_id,cur_dep',
                'employee.schedule:schedule_id,name,time_in,time_out',
                'employee.empData:emp_data_id,first_name,last_name',
            ])
            ->select(
                'attendances.attendance_id',
                'attendances.emp_id',
                'attendances.attendance_date',
                'attendances.state AS check_in.state',
                'attendances.status AS check_in.status',
                'attendances.attendance_time AS check_in_time',
                'leaves.state AS check_out.state',
                'leaves.status AS check_out.status',
                'leaves.leave_time AS check_out_time',
                'latetimes.duration AS latetime.duration',
                'latetimes.latetime_date AS latetime.latetime_date'
            )
            ->leftJoin('leaves', function ($join) {
                $join->on('attendances.emp_id', '=', 'leaves.emp_id')
                    ->whereRaw('leaves.leave_date = attendances.attendance_date')
                    ->whereNull('leaves.deleted_at');
            })
            ->leftJoin('latetimes', function ($join) {
                $join->on('attendances.emp_id', '=', 'latetimes.emp_id')
                    ->whereRaw('latetimes.latetime_date = attendances.attendance_date')
                    ->whereNull('latetimes.deleted_at');
            })
            ->latest('attendances.attendance_date')
            ->paginate(10)->toArray();
    }

    public function getAttendanceById(int $id): Attendance|Builder|null
    {
        $attendance = Attendance::query()->with([
            'employee:emp_id,schedule_id,emp_data_id,cur_dep',
            'employee.schedule:schedule_id,name,time_in,time_out',
            'employee.empData:emp_data_id,first_name,last_name'])
            ->find($id);

        if(!$attendance) return null;

        $eloquentLatetimeRepository = new EloquentLatetimeRepository();
        $late_time = $eloquentLatetimeRepository->getEmployeeLateByDate($attendance["emp_id"],$attendance["attendance_date"]);
        if($late_time){
            $attendance["latetime_id"]=$late_time["latetime_id"];
            $attendance["latetime_duration"]=$late_time["duration"];
            $attendance["latetime_date"]=$late_time["latetime_date"];
        }

        return $attendance;
    }

    public function getAttendanceByEmpId(int $emp_id): array|null
    {
        $attendances = Attendance::query()
            ->with([
                'employee:emp_id,schedule_id,emp_data_id,cur_dep',
                'employee.schedule:schedule_id,name,time_in,time_out',
                'employee.empData:emp_data_id,first_name,last_name',
            ])
            ->select(
                'attendances.attendance_id',
                'attendances.emp_id',
                'attendances.attendance_date',
                'attendances.state AS check_in.state',
                'attendances.status AS check_in.status',
                'attendances.attendance_time AS check_in_time',
                'leaves.state AS check_out.state',
                'leaves.status AS check_out.status',
                'leaves.leave_time AS check_out_time',
                'latetimes.duration AS latetime.duration',
                'latetimes.latetime_date AS latetime.latetime_date'
            )
            ->leftJoin('leaves', function ($join) {
                $join->on('attendances.emp_id', '=', 'leaves.emp_id')
                    ->whereRaw('leaves.leave_date = attendances.attendance_date')
                    ->whereNull('leaves.deleted_at');
            })
            ->leftJoin('latetimes', function ($join) {
                $join->on('attendances.emp_id', '=', 'latetimes.emp_id')
                    ->whereRaw('latetimes.latetime_date = attendances.attendance_date')
                    ->whereNull('latetimes.deleted_at');
            })
            ->where('attendances.emp_id', $emp_id)
            ->latest('attendances.attendance_date')
            ->paginate(10)->toArray();

        if(!$attendances) return null;


        return $attendances;
    }

    public function createAttendance(array $data): Attendance|Builder|null
    {

        if($att = Attendance::query()->where('emp_id',$data['emp_id'])->where('attendance_date',$data['attendance_date'])
            ->first()
        )
        {
            $att['message'] = "Employee has already checked-in in this day";
            return $att;
        }


        $attendance = Attendance::query()->create([
            'emp_id' => $data['emp_id'],
            'uid' => $data['uid'] ?? 0,
            'state' => $data['state'] ?? 0,
            'status' => $data['status'] ?? 1,
            'attendance_time' => $data['attendance_time'],
            'attendance_date' => $data['attendance_date'],
        ]);

        // Calculate Late time if exists
        $eloquentLatetimeRepository = new EloquentLatetimeRepository();
        if (!($attendance->employee->schedule->time_in >= $attendance["attendance_time"])) {
            $attendance["status"] = 0;
            $attendance->save();
            $late_time = $eloquentLatetimeRepository->createLatetime([
                "emp_id" => $attendance["employee"]["emp_id"],
                "attendance_time" => $attendance["attendance_time"],
                "schedule_time_in" => $attendance->employee->schedule->time_in,
                "latetime_date" => $attendance["attendance_date"]
                ]);

            $attendance["latetime_duration"]=$late_time["duration"];
            $attendance["latetime_date"]=$late_time["latetime_date"];
        }

        return $attendance;
    }

    public function updateAttendance(int $id, array $data): Attendance|Builder|null
    {
       $attendance = Attendance::query()->find($id);
       if(!$attendance) return null;

       $attendance['emp_id'] = $data['emp_id'] ?? $attendance['emp_id'];
       $attendance['state'] = $data['state'] ?? $attendance['state'];
       $attendance['attendance_time'] = $data['attendance_time'] ?? $attendance['attendance_time'];
       $attendance['attendance_date'] = $data['attendance_date'] ?? $attendance['attendance_date'];
       $attendance['status'] = $data['status'] ?? $attendance['status'];
       $attendance->save();


        $eloquentLatetimeRepository = new EloquentLatetimeRepository();
        if($attendance['attendance_time']) {
            if (!($attendance->employee->schedule->time_in >= $attendance["attendance_time"]))
            {
                $late_time = $eloquentLatetimeRepository->getEmployeeLateByDate($attendance["emp_id"],$attendance["attendance_date"]);
                if($late_time){
                    $eloquentLatetimeRepository->deleteLatetime($late_time->latetime_id);
                }

                $attendance["status"] = 0;
                $attendance->save();
                $late_time = $eloquentLatetimeRepository->createLatetime([
                    "emp_id" => $attendance["employee"]["emp_id"],
                    "attendance_time" => $attendance["attendance_time"],
                    "schedule_time_in" => $attendance->employee->schedule->time_in,
                    "latetime_date" => $attendance["attendance_date"]
                ]);

                $attendance["latetime_duration"]=$late_time["duration"];
                $attendance["latetime_date"]=$late_time["latetime_date"];
            }
            else
            {
                $late_time = $eloquentLatetimeRepository->getEmployeeLateByDate($attendance["emp_id"],$attendance["attendance_date"]);
                if($late_time) {
                    $attendance["status"]=1;
                    $eloquentLatetimeRepository->deleteLatetime($late_time->latetime_id);
                    $attendance->save();
                }
            }

        }

       return $attendance;
    }

    public function deleteAttendance($id): Attendance|Builder|null
    {
        $attendance = $this->getAttendanceById($id);

        if(!$attendance) return null;

        $attendance->delete();
        $eloquentLatetimeRepository = new EloquentLatetimeRepository();
        $eloquentLatetimeRepository->deleteLatetime($attendance['latetime_id']);

        return $attendance;
    }

    public function getEmployeeAttByDate($emp_id,$date): Attendance|Builder|null
    {
        $attendance = Attendance::query()->whereDate('attendance_date',$date)
            ->where('emp_id','=',$emp_id)->first();

        if(!$attendance) return null;


        return $attendance;
    }
}
