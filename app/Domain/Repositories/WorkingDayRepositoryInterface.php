<?php

namespace App\Domain\Repositories;

use App\Domain\Models\WorkingDay;
use Illuminate\Database\Eloquent\Builder;

interface WorkingDayRepositoryInterface
{
    public function getWorkingDayList(): array;

    public function updateWorkingDay(int $id, array $data): WorkingDay|Builder|null;

}
