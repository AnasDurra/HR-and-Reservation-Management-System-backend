<?php

namespace App\Domain\Repositories;

use App\Domain\Models\CD\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface AppointmentRepositoryInterface
{
    public function getAppointmentList(): LengthAwarePaginator;

    public function getAppointmentById(int $id): Appointment|Builder|null;

    public function createAppointment(array $data): Appointment|Builder|null;

    public function updateAppointment(int $id, array $data): Appointment|Builder|null;

    public function deleteAppointment($id): Appointment|Builder|null;
}
