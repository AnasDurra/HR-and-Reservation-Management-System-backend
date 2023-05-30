<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\AttendanceRepositoryInterface;
use App\Domain\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;

class EloquentAttendanceRepository implements AttendanceRepositoryInterface
{
    public function getAttendanceList(): array
    {
        return Attendance::query()->latest()->get()->toArray();
    }

    public function getAttendanceById(int $id): Attendance|Builder|null
    {
        $attendance = Attendance::query()->find($id);

        if(!$attendance) return null;

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
            ->paginate(1)->toArray();

        if(!$attendances) return null;


        return $attendances;
    }

    public function createAttendance(array $data): Attendance|Builder|null
    {

//    like as 0 => array:5 [▼
//              "uid" => 1      /* serial number of the attendance */
//              "id" => "1"     /* user id of the application */
//              "state" => 1    /* the authentication type, 1 for Fingerprint, 4 for RF Card etc */
//              "timestamp" => "2020-05-27 21:21:06" /* time of attendance */
//              "type" => 255   /* attendance type, like check-in, check-out, overtime-in, overtime-out, break-in & break-out etc. if attendance type is none of them, it gives  255. */
//              ]

        if($att = Attendance::query()->where('emp_id',$data['emp_id'])->where('attendance_date',$data['attendance_date'])
            ->first()
        )
        {
            $att['message'] = "Employee has already checked-in in this day";
            return $att;
        }

        return Attendance::query()->create([
            'emp_id' => $data['emp_id'],
            'uid' => $data['uid'] ?? 0,
            'state' => $data['state'] ?? 1,
            'attendance_time' => $data['attendance_time'],
            'attendance_date' => $data['attendance_date'],
        ]);
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

       return $attendance;
    }

    public function deleteAttendance($id): Attendance|Builder|null
    {
        $attendance = Attendance::query()->find($id);

        if(!$attendance) return null;

        $attendance->delete();
        return $attendance;
    }

    public function getEmployeeAttByDate($id,$date): Attendance|Builder|null
    {
        $attendance = Attendance::query()->whereDate('attendance_date',$date)->find($id);

        if(!$attendance) return null;


        return $attendance;
    }
}
