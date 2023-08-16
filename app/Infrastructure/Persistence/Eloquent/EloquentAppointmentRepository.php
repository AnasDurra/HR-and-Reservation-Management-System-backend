<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\AppointmentRepositoryInterface;
use App\Domain\Models\CD\Appointment;
use App\Exceptions\InvalidArgument;
use Exception;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAppointmentList(): array
    {
        // TODO: Implement the logic to retrieve a list of Appointments
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

    /**
     * @throws EntryNotFoundException
     */
    public function attendanceModification($app_id, $status_id): Appointment|Builder|null
    {
        try {
            $appointment = Appointment::query()->findOrFail($app_id);

            //status_id must be 4 or 7 or 8

            // Check if status_id is within the specified range
            $validStatuses = [4, 7, 8];
            if (!in_array($status_id, $validStatuses))
                abort(400, "Invalid status id");


            $appointment->status_id = $status_id;
            $appointment->save();

            return $appointment;
        } catch (Exception $exception) {
//            throw new EntryNotFoundException("Appointment with ID $app_id not found.");
            throw $exception;

        }

    }
}
