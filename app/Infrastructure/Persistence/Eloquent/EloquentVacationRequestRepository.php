<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\VacationRequest;
use App\Domain\Repositories\VacationRequestRepositoryInterface;
use App\Exceptions\EntryNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentVacationRequestRepository implements VacationRequestRepositoryInterface
{
    public function getVacationRequestList(): LengthAwarePaginator
    {
        $vacation_request = VacationRequest::query();

        $req_stat = request('req_stat');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $start_date_st = request('start_date_st');
        $end_date_st = request('end_date_st');
        $start_date_ed = request('start_date_ed');
        $end_date_ed = request('end_date_ed');

        // query parameters for shift with date range


        if ($req_stat) {
            $vacation_request->where('req_stat', '=', $req_stat);
        }

        if ($start_date) {
            $vacation_request->where('start_date', '=', $start_date);
        }
        if ($end_date) {
            $vacation_request->where('end_date', '=', $end_date);
        }

        //filter by date range
        if ($start_date_st && $end_date_st) {
            $vacation_request->whereBetween('start_date', [$start_date_st, $end_date_st]);
        }
        if ($start_date_ed && $end_date_ed) {
            $vacation_request->whereBetween('end_date', [$start_date_ed, $end_date_ed]);
        }

        return $vacation_request->with(['employee'])->paginate(10);

    }

    /**
     * @throws EntryNotFoundException
     */
    public function getVacationRequestById(int $id): VacationRequest|Builder
    {
        try {
            return VacationRequest::query()->findOrFail($id);
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");

        }
    }

    /**
     * @throws Exception
     */
    public function createVacationRequest(array $data): VacationRequest|Builder
    {
        return VacationRequest::query()->create([
            "emp_id" => $data["emp_id"],
            "req_stat" => '1',
            "description" => $data["description"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"]
        ]);

    }

    /**
     * @throws EntryNotFoundException
     */
    public function updateVacationRequest(int $id, array $data): VacationRequest|Builder
    {
        try {
            $vacationRequest = VacationRequest::query()->findOrFail($id);
            $vacationRequest['description'] = $data["description"] ?? $vacationRequest['description'];
            $vacationRequest['start_date'] = $data["start_date"] ?? $vacationRequest['start_date'];
            $vacationRequest['end_date'] = $data["end_date"] ?? $vacationRequest['end_date'];
            $vacationRequest->save();
            return $vacationRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }

    }

    /**
     * @throws EntryNotFoundException
     */
    public function deleteVacationRequest($id): VacationRequest|Builder|null
    {
        try {
            $vacationRequest = VacationRequest::query()->findOrFail($id)->first();
            $vacationRequest->delete();
            return $vacationRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }
    }

    /**
     * @throws EntryNotFoundException
     */
    public function acceptVacationRequest($id): VacationRequest|Builder
    {
        try {
            $vacationRequest = VacationRequest::query()->where("req_stat", '=', 1)->findOrFail($id);
            $vacationRequest->update([
                "req_stat" => 2
            ]);
            return $vacationRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }

    }

    /**
     * @throws EntryNotFoundException
     */
    public function rejectVacationRequest($id): VacationRequest|Builder
    {
        try {
            $vacationRequest = VacationRequest::query()->where("req_stat", '=', 1)->findOrFail($id);
            $vacationRequest->update([
                "req_stat" => 3
            ]);
            return $vacationRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }
    }
}