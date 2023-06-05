<?php

namespace App\Domain\Services;

use App\Domain\Repositories\WorkingDayRepositoryInterface;
use App\Domain\Models\WorkingDay;
use Illuminate\Database\Eloquent\Builder;

class WorkingDayService
{
    private WorkingDayRepositoryInterface $WorkingDayRepository;

    public function __construct(WorkingDayRepositoryInterface $WorkingDayRepository)
    {
        $this->WorkingDayRepository = $WorkingDayRepository;
    }

    public function getWorkingDayList(): array
    {
        return $this->WorkingDayRepository->getWorkingDayList();
    }

    public function updateWorkingDay(int $id, array $data): WorkingDay|Builder|null
    {
        return $this->WorkingDayRepository->updateWorkingDay($id, $data);
    }

}
