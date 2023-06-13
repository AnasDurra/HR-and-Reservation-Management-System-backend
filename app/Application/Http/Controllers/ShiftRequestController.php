<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\ShiftRequestResource;
use App\Domain\Services\ShiftRequestService;
use App\Exceptions\EntryNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class ShiftRequestController extends Controller
{
    private ShiftRequestService $ShiftRequestService;

    public function __construct(ShiftRequestService $ShiftRequestService)
    {
        $this->ShiftRequestService = $ShiftRequestService;
    }

    public function index(): AnonymousResourceCollection
    {
        $shiftRequests = $this->ShiftRequestService->getShiftRequestList();
        return ShiftRequestResource::collection($shiftRequests);

    }

    public function show(int $id): ShiftRequestResource
    {
        $shiftRequest = $this->ShiftRequestService->getShiftRequestById($id);
        return new ShiftRequestResource($shiftRequest);
    }

    public function store(): MessageBag|ShiftRequestResource
    {
        $validator = Validator::make(request()->all(), [
//            'emp_id' => ['required', 'integer', 'exists:employees,emp_id'],
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            'description' => ['required', 'string'],
            'new_time_in' => ['required', 'date_format:H:i:s'],
            'new_time_out' => ['required', 'date_format:H:i:s'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $shiftRequest = $this->ShiftRequestService->createShiftRequest(request()->all());
        return new ShiftRequestResource($shiftRequest);
    }

    /**
     * @throws ValidationException
     */
    public function update(int $id): MessageBag|ShiftRequestResource
    {
        $validator = Validator::make(request()->all(), [
            'description' => ['string'],
            'new_time_in' => ['date_format:H:i:s'],
            'new_time_out' => ['date_format:H:i:s'],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => ['date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $shiftRequest = $this->ShiftRequestService->updateShiftRequest($id, $validator->validated());

        return new ShiftRequestResource($shiftRequest);

    }

    public function destroy(int $id): ShiftRequestResource
    {
        $shiftRequest = $this->ShiftRequestService->deleteShiftRequest($id);
        return new ShiftRequestResource($shiftRequest);
    }

    /**
     * @throws EntryNotFoundException
     */
    public function acceptShiftRequest($id): ShiftRequestResource
    {
        $shiftRequest = $this->ShiftRequestService->acceptShiftRequest($id);
        return new ShiftRequestResource($shiftRequest);
    }

    public function rejectShiftRequest($id): ShiftRequestResource
    {
        $shiftRequest = $this->ShiftRequestService->rejectShiftRequest($id);
        return new ShiftRequestResource($shiftRequest);
    }
}
