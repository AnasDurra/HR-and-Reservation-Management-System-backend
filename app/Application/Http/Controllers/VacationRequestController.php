<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\VacationRequestResource;
use App\Domain\Services\VacationRequestService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class VacationRequestController extends Controller
{
    private VacationRequestService $VacationRequestService;

    public function __construct(VacationRequestService $VacationRequestService)
    {
        $this->VacationRequestService = $VacationRequestService;
    }

    public function index(): AnonymousResourceCollection
    {
        $vacationRequests = $this->VacationRequestService->getVacationRequestList();
        return VacationRequestResource::collection($vacationRequests);
    }

    public function show(int $id): VacationRequestResource
    {
        $vacationRequest = $this->VacationRequestService->getVacationRequestById($id);
        return new VacationRequestResource($vacationRequest);
    }

    /**
     * @throws ValidationException
     */
    public function store(): VacationRequestResource|MessageBag
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            //'req_stat' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date', 'after:yesterday'],
            'duration' => ['required', 'int'],
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $vacationRequest = $this->VacationRequestService->createVacationRequest($validator->validated());

        return new VacationRequestResource($vacationRequest);

    }

    /**
     * @throws ValidationException
     */
    public function update(int $id): MessageBag|VacationRequestResource
    {
        $validator = Validator::make(request()->all(), [
            'description' => ['string'],
            'start_date' => ['date'],
            'duration' => ['int'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
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
