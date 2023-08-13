<?php

namespace App\Domain\Services;

use App\Domain\Repositories\AppointmentRepositoryInterface;
use App\Domain\Models\CD\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AppointmentService
{
    private AppointmentRepositoryInterface $AppointmentRepository;

    public function __construct(AppointmentRepositoryInterface $AppointmentRepository)
    {
        $this->AppointmentRepository = $AppointmentRepository;
    }

    public function getAppointmentList(): LengthAwarePaginator
    {
        return $this->AppointmentRepository->getAppointmentList();
    }

    public function getAppointmentById(int $id): Appointment|Builder|null
    {
        return $this->AppointmentRepository->getAppointmentById($id);
    }

    public function createAppointment(array $data): Appointment|Builder|null
    {
        return $this->AppointmentRepository->createAppointment($data);
    }

    public function updateAppointment(int $id, array $data): Appointment|Builder|null
    {
        return $this->AppointmentRepository->updateAppointment($id, $data);
    }

    public function deleteAppointment($id): Appointment|Builder|null
    {
        return $this->AppointmentRepository->deleteAppointment($id);
    }
}
