<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\AppointmentRepositoryInterface;
use App\Domain\Models\CD\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAppointmentList(): LengthAwarePaginator
    {
        return Appointment::query()->paginate(10);
    }

    public function getAppointmentById(int $id): Appointment|Builder|null
    {
        // TODO: Implement the logic to retrieve a Appointment by ID
    }

    public function createAppointment(array $data): Appointment|Builder|null
    {
        // TODO: Implement the logic to create a Appointment
    }

    public function updateAppointment(int $id, array $data): Appointment|Builder|null
    {
        // TODO: Implement the logic to update a Appointment
    }

    public function deleteAppointment($id): Appointment|Builder|null
    {
        // TODO: Implement the logic to delete a Appointment
    }
}
