<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Models\CD\Appointment;
use App\Domain\Models\CD\Customer;
use App\Domain\Models\CD\Shift;
use App\Domain\Models\CD\WorkDay;
use App\Domain\Repositories\TimeSheetRepositoryInterface;
use App\Exceptions\EntryNotFoundException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

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
     * @throws Throwable
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
     * @throws Throwable
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
            throw new EntryNotFoundException("Entry with ID $id not found.");
        }
    }

    /**
     * @throws EntryNotFoundException
     * @throws Throwable
     */
    public function addWorkDay(array $data): void
    {
        try {

            DB::beginTransaction();
            foreach ($data['dates'] as $date) {

                // first, check that there is no record with the same date and shift
                $records = WorkDay::query()
                    ->where('day_date', $date['date'])
                    ->where('shift_id', $date['shift_Id'])
                    ->get();

                if ($records->count() > 0) {
//                    throw new DuplicatedEntryException("تم بالفعل اسناد جدول دوام لليوم المحدد");
                    abort(400, "تم بالفعل اسناد جدول دوام لليوم المحدد");
                }

                $work_day = WorkDay::query()->create([
                    'shift_id' => $date['shift_Id'],
                    'day_date' => $date['date'],
                ]);


                $shift = Shift::query()->find($date['shift_Id'])->first();


                // get the intervals associated with the shift and insert them as appointments
                foreach ($shift->intervals as $interval) {
                    $start_time = $interval->start_time;
                    $end_time = $interval->end_time;

                    Appointment::query()->create([
                        'work_day_id' => $work_day->id,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'customer_id' => null,
                        'status_id' => 6,
                        'cancellation_reason' => null,
                    ]);
                }

            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws EntryNotFoundException
     */
    public function bookAnAppointmentByEmployee(int $appointment_id, int $customer_id): Appointment|Builder|null
    {
        try {
            $appointment = Appointment::query()->findOrFail($appointment_id);

            // test if the date is not expired
            //TODO : today considered in the past
            $work_day = WorkDay::query()->find($appointment->work_day_id);
            $targetDate = Carbon::parse($work_day->day_date);
            if ($targetDate->isPast()) {
                throw new EntryNotFoundException("Can't update the appointment , the date is expired");
            }

            //test if the customer is not verified or blocked
            $customer = Customer::query()->findOrFail($customer_id);
            if ($customer['blocked'] == 1 || $customer['verified'] == 0) {
                throw new EntryNotFoundException("Can't update the appointment , the customer is blocked or unverified");
            }

        } catch (Exception $exception) {
//            throw new EntryNotFoundException("Appointment with ID $appointment_id not found.");
            throw $exception;
        }

        $appointment->customer_id = $customer_id;
        $appointment->save();

        return $appointment;
    }


    //TODO : pagination
    public function getConsultantSchedule(): LengthAwarePaginator
    {
        //TODO : uncomment this lines
//        $user_id = Auth::id();
//        $consultant = Consultant::query()->where('user_id', '=', $user_id)->first();
//        $shift = Shift::query()->where('consultant_id', '=', $consultant_id->consultant_id);


        //TODO : delete this line
        $shift = Shift::query()->where('consultant_id', '=', 1);

        return $shift->paginate(10);
    }


    /**
     * @throws EntryNotFoundException
     */
    public function cancelAppointmentByConsultant($id): Appointment|Builder|null
    {
        try {
            $canceled_appointment = Appointment::query()->findOrFail($id);

            //TODO : check if the number is correct
            $canceled_appointment->status_id = '7';
            $canceled_appointment->save();

            return $canceled_appointment;
        } catch (Exception) {
            throw new EntryNotFoundException("Appointment with ID $id not found.");
        }
    }

    public function getCanceledAppointment(): LengthAwarePaginator
    {
        //TODO : check if the number is correct
        return Appointment::query()
            ->where('status_id', '=', '7')
            ->paginate(10);
    }

    public function cancelReservationByCustomer($appointment): Appointment|Builder|null
    {
        $appointment->update([
            'status_id' => 1,
        ]);

        // Notify the consultant
        return $appointment;
    }

    public function cancelReservationByEmployee($appointment): Appointment|Builder|null
    {
        // set the status to canceled by employee
        $appointment->update([
            'status_id' => 2,
        ]);

        // TODO: Notify the customer & consultant

        return $appointment;
    }

    public function cancelReservationByConsultant($appointment): Appointment|Builder|null
    {
        // set the status to canceled by consultant
        $appointment->update([
            'status_id' => 3,
        ]);

        // TODO: Notify the customer & consultant

        return $appointment;
    }

    public function cancelReservation(Appointment $appointment): Appointment|Builder|null
    {
        // set the status to canceled by consultant
        $appointment->update([
            'status_id' => 6,
            'customer_id' => null,
        ]);

        return $appointment;
    }
}
