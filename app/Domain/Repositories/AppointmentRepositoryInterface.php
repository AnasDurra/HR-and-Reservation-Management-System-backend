<?php

namespace App\Domain\Repositories;

use App\Domain\Models\CD\Appointment;
use App\Domain\Models\CD\CaseNote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface AppointmentRepositoryInterface
{
    public function getAppointmentList(): LengthAwarePaginator;

    public function getAppointmentById(int $id): Appointment|Builder|null;

    public function createAppointment(array $data): Appointment|Builder|null;

    public function updateAppointment(int $id, array $data): Appointment|Builder|null;

    public function deleteAppointment($id): Appointment|Builder|null;

    public function attendanceModification($app_id, $status_id): Appointment|Builder|null;

    public function appointmentPreview(array $data): CaseNote|Builder|null;
}
