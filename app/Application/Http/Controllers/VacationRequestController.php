<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\ShiftRequestResource;
use App\Application\Http\Resources\VacationRequestResource;
use App\Domain\Services\VacationRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VacationRequestController extends Controller
{
    private VacationRequestService $VacationRequestService;

    public function __construct(VacationRequestService $VacationRequestService)
    {
        $this->VacationRequestService = $VacationRequestService;
    }

    public function index(): VacationRequestResource
    {
        $vacationRequests = $this->VacationRequestService->getVacationRequestList();
        return new VacationRequestResource($vacationRequests);
    }

    public function show(int $id): VacationRequestResource
    {
        $vacationRequest = $this->VacationRequestService->getVacationRequestById($id);
        return new VacationRequestResource($vacationRequest);
    }

    /**
     * @throws ValidationException
     */
    public function store(): ShiftRequestResource|JsonResponse
    {
        $validator = Validator::make(request()->all(), [
            'emp_id' => ['required', 'integer', 'exists:employees,emp_id'],
            //'req_stat' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(new VacationRequestResource($errors))->json([
                'data' => new VacationRequestResource($errors)
            ], 400);
        }
        $vacationRequest = $this->VacationRequestService->createVacationRequest($validator->validated());

        return new ShiftRequestResource($vacationRequest);

    }

    /**
     * @throws ValidationException
     */
    public function update(int $id): VacationRequestResource
    {
        $validator = Validator::make(request()->all(), [
            'description' => ['string'],
            'start_date' => ['date', 'before:end_date'],
            'end_date' => ['date', 'after:start_date'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return new VacationRequestResource($errors);
        }
        $vacationRequest = $this->VacationRequestService->updateVacationRequest($id, $validator->validated());

        return new VacationRequestResource($vacationRequest);
    }

    public function destroy(int $id): VacationRequestResource
    {
        $vacationRequest = $this->VacationRequestService->deleteVacationRequest($id);
        return new VacationRequestResource($vacationRequest);
    }

    public function acceptVacationRequest(int $id): VacationRequestResource
    {
        $vacationRequest = $this->VacationRequestService->acceptVacationRequest($id);
        return new VacationRequestResource($vacationRequest);
    }

    public function rejectVacationRequest(int $id): VacationRequestResource
    {
        $vacationRequest = $this->VacationRequestService->rejectVacationRequest($id);
        return new VacationRequestResource($vacationRequest);
    }
}
