<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\WorkingDayRepositoryInterface;
use App\Domain\Models\WorkingDay;
use Illuminate\Database\Eloquent\Builder;

class EloquentWorkingDayRepository implements WorkingDayRepositoryInterface
{
    public function getWorkingDayList(): array
    {
        return WorkingDay::all()->toArray();
    }

    public function updateWorkingDay(int $id, array $data): WorkingDay|Builder|null
    {
        $working_day = workingDay::query()->find($id);

        if(!$working_day)
            return null;

        $working_day->status = $data['status'];
        $working_day->save();

        return $working_day;
    }

}
