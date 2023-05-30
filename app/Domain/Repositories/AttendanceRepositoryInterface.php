<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;

interface AttendanceRepositoryInterface
{
    public function getAttendanceList(): array;

    public function getAttendanceById(int $id): Attendance|Builder|null;

    public function createAttendance(array $data): Attendance|Builder|null;

    public function updateAttendance(int $id, array $data): Attendance|Builder|null;

    public function deleteAttendance($id): Attendance|Builder|null;

    public function getEmployeeAttByDate($id,$date): Attendance|Builder|null;

}
