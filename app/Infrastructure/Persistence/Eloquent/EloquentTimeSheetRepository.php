<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\CD\Shift;
use App\Domain\Repositories\TimeSheetRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentTimeSheetRepository implements TimeSheetRepositoryInterface
{
    public function getTimeSheetList(): LengthAwarePaginator
    {
        $time_sheet = Shift::query()->with('intervals');

        // check if the request has search by employee name
        if (request()->has('name')) {
            $name = request()->query('name');

            // trim the name
            $name = trim($name);

            // make the name lower case
            $name = strtolower($name);

            $time_sheet->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        }

        return $time_sheet->paginate(10);

    }


    private function getIntervalIdIfExists(mixed $startTime, mixed $endTime)
    {
        $interval = DB::table('intervals')
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->first();

        return $interval?->id;
    }

    /**
     * @throws \Throwable
     */
    public function createTimeSheet(array $data): Shift|Builder|null
    {
        try {
            DB::beginTransaction();

            $shift = Shift::query()->create([
                'consultant_id' => '1',
                //TODO : uncomment this
                //'consultant_id' => \Auth::id(),
                'name' => $data['name'],
                //TODO : remove this
                'slot_duration' => '30',
            ]);

            foreach ($data['periods'] as $period) {
                $start_time = $period['start_time'];
                $end_time = $period['end_time'];

                $intervalId = $this->getIntervalIdIfExists($start_time, $end_time);

                // If the interval doesn't exist, create a new record and get its ID
                if (!$intervalId) {
                    $intervalId = DB::table('intervals')->insertGetId([
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
                }

                $shift->intervals()->attach($intervalId);
            }

            DB::commit();
            return $shift;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    /**
     * @throws \Throwable
     */
    public function deleteTimeSheet($id): Shift|Builder|null
    {
        try {
            DB::beginTransaction();

            $shift = Shift::query()->findOrFail($id);
            $shift->intervals()->detach();
            $shift->delete();

            DB::commit();
            return $shift;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}
