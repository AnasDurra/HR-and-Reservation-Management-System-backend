<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ScheduleRepositoryInterface;
use App\Domain\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;

class EloquentScheduleRepository implements ScheduleRepositoryInterface
{
    public function getScheduleList(): array
    {
        return Schedule::all()->toArray();
    }

    public function getScheduleById(int $id): Schedule|Builder|null
    {
        return Schedule::query()->find($id);
    }

    public function createSchedule(array $data): Schedule|Builder|null
    {
        return Schedule::query()->create([
           "name" => $data["name"],
           "time_in" => $data["time_in"],
           "time_out" => $data["time_out"],
        ]);
    }

    public function updateSchedule(int $id, array $data): Schedule|Builder|null
    {
        $schedule = Schedule::query()->find($id);
        if(!$schedule) return null;

        $schedule["name"] = $data['name'] ?? $schedule["name"];
        $schedule["time_in"] = $data['time_in'] ?? $schedule["time_in"];
        $schedule["time_out"] = $data['time_out'] ?? $schedule["time_out"];
        $schedule->save();

        return $schedule;
    }

    public function deleteSchedule($id): Schedule|Builder|null
    {
        $schedule = Schedule::query()->find($id);
        if(!$schedule) return null;

        // TODO something
        $schedule->delete();

        return $schedule;
    }
}
