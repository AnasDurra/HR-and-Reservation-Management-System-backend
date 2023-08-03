<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\StoreTimeSheetRequest;
use App\Application\Http\Resources\TimeSheetResource;
use App\Domain\Services\TimeSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TimeSheetController extends Controller
{
    private TimeSheetService $TimeSheetService;

    public function __construct(TimeSheetService $TimeSheetService)
    {
        $this->TimeSheetService = $TimeSheetService;
    }

    public function index(): AnonymousResourceCollection
    {
        $timeSheets = $this->TimeSheetService->getTimeSheetList();
        return TimeSheetResource::collection($timeSheets);
    }


    public function store(StoreTimeSheetRequest $request): JsonResponse
    {
        // validate request data
        $validated = $request->validated();

        // create job application
        $this->TimeSheetService->createTimeSheet($validated);

        return response()->json([
            'message' => 'Time Sheet Created Successfully'
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $this->TimeSheetService->deleteTimeSheet($id);
        return response()->json([
            'message' => 'Time Sheet Deleted Successfully'
        ]);
    }
}
