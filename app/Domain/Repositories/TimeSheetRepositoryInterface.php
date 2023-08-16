<?php

namespace App\Domain\Repositories;

use App\Domain\Models\CD\Appointment;
use App\Domain\Models\CD\Shift;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TimeSheetRepositoryInterface
{
    public function getTimeSheetList(): LengthAwarePaginator;

    public function createTimeSheet(array $data): Shift|Builder|null;

    public function deleteTimeSheet($id): Shift|Builder|null;

    public function addWorkDay(array $data): Model|Builder;

    public function bookAnAppointmentByEmployee(int $appointment_id, int $customer_id): Appointment|Builder|null;

    public function getConsultantSchedule(): LengthAwarePaginator;

    public function cancelAppointmentByConsultant($id): Appointment|Builder|null;

    public function getCanceledAppointment(): LengthAwarePaginator;

    public function cancelReservationByCustomer(Appointment $appointment): Appointment|Builder|null;

    public function cancelReservationByEmployee(Appointment $appointment): Appointment|Builder|null;

    public function cancelReservationByConsultant(Appointment $appointment): Appointment|Builder|null;

    public function cancelReservation(Appointment $appointment): Appointment|Builder|null;
}
