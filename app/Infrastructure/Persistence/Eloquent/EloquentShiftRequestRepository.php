<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\Employee;
use App\Domain\Repositories\ShiftRequestRepositoryInterface;
use App\Domain\Models\ShiftRequest;
use App\Exceptions\EntryNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Pagination\LengthAwarePaginator;


class EloquentShiftRequestRepository implements ShiftRequestRepositoryInterface
{
    public function getShiftRequestList(): LengthAwarePaginator
    {
        $shift_requests = ShiftRequest::query();

        $req_stat = request('req_stat');
        $new_time_in = request('new_time_in');
        $new_time_out = request('new_time_out');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $start_date_st = request('start_date_st');
        $end_date_st = request('end_date_st');
        $start_date_ed = request('start_date_ed');
        $end_date_ed = request('end_date_ed');

        // query parameters for shift with date range


        if ($req_stat) {
            $shift_requests->where('req_stat', '=', $req_stat);
        }

        if ($new_time_in) {
            $shift_requests->where('new_time_in', '=', $new_time_in);
        }
        if ($new_time_out) {
            $shift_requests->where('new_time_out', '=', $new_time_out);
        }
        if ($start_date) {
            $shift_requests->where('start_date', '=', $start_date);
        }
        if ($end_date) {
            $shift_requests->where('end_date', '=', $end_date);
        }

        //filter by date range
        if ($start_date_st && $end_date_st) {
            $shift_requests->whereBetween('start_date', [$start_date_st, $end_date_st]);
        }
        if ($start_date_ed && $end_date_ed) {
            $shift_requests->whereBetween('end_date', [$start_date_ed, $end_date_ed]);
        }

        return $shift_requests->with(['employee'])->paginate(10);

    }

    public function getShiftRequestById(int $id): ShiftRequest|Builder|array|Collection|Model|null
    {
        return ShiftRequest::query()->with(['employee'])->findOrFail($id)->first();
    }

    /**
     * @throws Exception
     */
    public function createShiftRequest(array $data): ShiftRequest|Builder|null
    {

        // get the user id from data
        $user_id = $data['user_id'];

        // get the employee id from the user id
        $emp_id = Employee::query()->where('user_id', '=', $user_id)->firstOrFail()->emp_id;

        return ShiftRequest::query()->create([
            "emp_id" => $data["emp_id"],
            "req_stat" => '1',
            "description" => $data["description"],
            "new_time_in" => $data["new_time_in"],
            "new_time_out" => $data["new_time_out"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
        ]);
    }

    /**
     * @throws EntryNotFoundException
     */
    public
    function updateShiftRequest(int $id, array $data): ShiftRequest|Builder|null
    {
        try {
            $shiftRequest = ShiftRequest::query()->findOrFail($id);
            $shiftRequest->description = $data['description'] ?? $shiftRequest->description;
            $shiftRequest->new_time_in = $data['new_time_in'] ?? $shiftRequest->new_time_in;
            $shiftRequest->new_time_out = $data['new_time_out'] ?? $shiftRequest->new_time_out;
            $shiftRequest->start_date = $data['start_date'] ?? $shiftRequest->start_date;
            $shiftRequest->end_date = $data['end_date'] ?? $shiftRequest->end_date;

            $shiftRequest->save();
            return $shiftRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }
    }


    /**
     * @throws EntryNotFoundException
     */
    public function deleteShiftRequest($id): ShiftRequest|Builder|null
    {
        try {
            $shiftRequest = ShiftRequest::query()
                ->where('shift_req_id', '=', $id)->findOrFail();
            $shiftRequest->delete();
            return $shiftRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }

    }

    //TODO : handle where req_id != 1

    /**
     * @throws EntryNotFoundException
     */
    public function acceptShiftRequest($id): ShiftRequest|Builder|null
    {
        try {
            $shiftRequest = ShiftRequest::query()->where("req_stat", '=', 1)->findOrFail($id);

            $shiftRequest->req_stat = 2;

            $shiftRequest->save();

            return $shiftRequest;

        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }
    }

    /**
     * @throws EntryNotFoundException
     */
    public function rejectShiftRequest($id): Builder|ShiftRequest
    {
        try {
            $shiftRequest = ShiftRequest::query()->where("req_stat", '=', 1)->findOrFail($id);

            $shiftRequest->req_stat = 3;

            $shiftRequest->save();

            return $shiftRequest;
        } catch (Exception $exception) {
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }

    }

}
